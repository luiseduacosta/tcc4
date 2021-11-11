<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Routing\Router;
use App\Controller\AppController;
use Cake\Utility\Text;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

/**
 * Monografias Controller
 *
 * @property \App\Model\Table\MonografiasTable $Monografias
 *
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MonografiasController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {

        parent::beforeFilter($event);
        // $this->Authorization->skipAuthorization();
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'busca', 'download']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {

        $this->Authorization->skipAuthorization();
        $this->paginate['contain'] = ['Docentes', 'Docentes1', 'Docentes2', 'Areamonografias', 'Tccestudantes' => ['sort' => 'Tccestudantes.nome']];
        $this->paginate['sortWhitelist'] = [
            'Monografias.titulo',
            'Monografias.periodo',
            'Monografias.url',
            'Tccestudantes.nome',
            'Docentes.nome',
            'Areamonografias.area'];
        $monografias = $this->paginate($this->Monografias);
        $baseUrl = Router::url('/', true);
        $this->set(compact('monografias', 'baseUrl'));
    }

    /**
     * View method
     *
     * @param string|null $id Monografia id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->Authorization->skipAuthorization();
        $monografia = $this->Monografias->get($id, [
            'contain' => ['Docentes', 'Docentes1', 'Docentes2', 'Areamonografias', 'Tccestudantes'],
        ]);
        // pr($monografia);
        // die();
        // $baseUrl = Router::url('/', true);

        $this->set(compact('monografia'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $monografia = $this->Monografias->newEmptyEntity();
        $this->Authorization->authorize($monografia);
        // pr($monografia);

        if ($this->request->is('post')) {

            $dados = $this->request->getData();
            // pr($dados['registro']);

            if ($this->request->getUploadedFile('url')->getSize() > 0):
                $dados['url'] = $this->arquivo($dados);
            // die();
            endif;
            /* Ajusto o periodo agregando ano e semestre */
            // pr($dados['ano']);
            // pr($dados['semestre']);
            $periodo = $dados['ano'] . "-" . $dados['semestre'];
            $dados['periodo'] = $periodo;

            $dados['data'] = $dados['data_de_entrega'];

            /* Data defesa */
            $dados['data_defesa'] = $dados['data_banca'];

            /* Banca1 eh o próprio docente orientador */
            if (empty($dados['banca1'])):
                $dados['banca1'] = $dados['docente_id'];
            endif;

            // pr($dados);
            // die();
            // $monografia = $this->Monografias->patchEntity($monografia, $this->request->getData());
            $monografia = $this->Monografias->patchEntity($monografia, $dados);
            $this->Authorization->authorize($monografia);
            // pr($monografia);
            // die();
            if ($this->Monografias->save($monografia)) {
                $this->Flash->success(__('The monografia has been saved.'));

                /* Tem que inserir o Tccestudante */
                $tccestudante = $this->Monografias->Tccestudantes->newEmptyEntity();

                /* Capturo o nome do estudante */
                $this->loadModel('Estudantes');
                $resultado = $this->Estudantes->find('all');
                $resultado->where(['registro' => $dados['registro']]);
                $resultado->select(['nome']);
                $resultado->first();

                /* Array com os dados para inserir */
                $dadosestudante['monografia_id'] = $monografia->id;
                $dadosestudante['registro'] = $dados['registro'];
                $dadosestudante['nome'] = $resultado->first()->nome;
                // pr($dadosestudante);
                // die('dadosestudante');
                $tccaluno = $this->Monografias->Tccestudantes->patchEntity($tccestudante, $dadosestudante);
                if ($this->Monografias->Tccestudantes->save($tccaluno)) {
                    $this->Flash->success(__('The Tccestudantes has been saved.'));
                    return $this->redirect(['controller' => 'Monografias', 'action' => 'view', $monografia->id]);
                }
                $this->Flash->error(__('The Tccestudantes could not be saved. Please, try again.'));
            }
            $this->Flash->error(__('The Monografias could not be saved. Please, try again.'));
        }

        /* Chamo a function estudantes() para fazer o list de seleção */
        $estudantes = $this->estudantes();
        // pr($estudantes);
        /* Deveria ser somente para professores ativos */
        $professores = $this->Monografias->Docentes->find('list',
                ['keyField' => 'id', 'valueField' => 'nome']);
        // $professores->where(['dataegresso IS NULL']);
        $professores->order(['nome']);
        // debug($professores->toArray());
        // pr($professores);
        $areas = $this->Monografias->Areamonografias->find('list', [
            'keyField' => 'id', 'valueField' => 'area'],
                ['limit' => 200]);
        $this->set(compact('estudantes', 'monografia', 'professores', 'areas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Monografia id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $monografia = $this->Monografias->get($id, [
            'contain' => ['Docentes', 'Docentes1', 'Docentes2', 'Areamonografias', 'Tccestudantes'],
        ]);

        $this->Authorization->authorize($monografia);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $dados = $this->request->getData();
            // pr($dados['url']);

            if ($this->request->getUploadedFile('url')->getSize() > 0):
                // echo 'Arquivo PDF';
                /* Preciso do DRE para inserir uma monografia */
                $resultado = $this->Monografias->Tccestudantes->find('all')
                        ->where(['Tccestudantes.monografia_id' => $id])
                        ->order(['Tccestudantes.nome']);
                $registro = $resultado->first();
                $dre = $registro->registro;
                // $url->moveTo(WWW_ROOT . 'monografias/');

                /* Chamo a função arquivo() com os parámetros do formulário e do $dre */
                $dados['url'] = $this->arquivo($dados, $dre);
            // die();
            elseif (!empty($dados['url_atual'])):
                $dados['url'] = $dados['url_atual'];
            else:
                $dados['url'] = null;
            endif;
            // pr($dados['url']);
            // die();

            $monografia = $this->Monografias->patchEntity($monografia, $dados);
            // pr($monografia);
            if ($this->Monografias->save($monografia)) {
                $this->Flash->success(__('The monografia has been saved.'));

                return $this->redirect(['action' => 'view/' . $id]);
            }
            $this->Flash->error(__('The monografia could not be saved. Please, try again.'));
        }

        // $estudantes = $this->estudantes();

        $docentes = $this->Monografias->Docentes->find('list', [
            'keyField' => 'id', 'valueField' => 'nome'], ['limit' => 200]);
        $docentes->order(['nome' => 'asc']);

        $areas = $this->Monografias->Areamonografias->find('list', [
            'keyField' => 'id', 'valueField' => 'area'], ['limit' => 200]);
        $areas->order(['area' => 'asc']);

        $this->set(compact('monografia', 'docentes', 'areas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Monografia id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $monografia = $this->Monografias->get($id);
        $this->Authorization->authorize($monografia);

        if ($this->Monografias->delete($monografia)) {
            $this->Flash->success(__('The monografia has been deleted.'));
        } else {
            $this->Flash->error(__('The monografia could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function busca() {

        $this->Authorization->skipAuthorization();
        if ($this->request->is('post')) {
            // echo "Post" . "<br>";
            if ($this->request->getData()):
                $dados = $this->request->getData();
                $busca = $dados['titulo'];
                $this->getRequest()->getSession()->write('busca', $busca);
                $this->paginate = [
                    'conditions' => ['titulo LIKE' => "%" . $busca . "%"],
                    'contain' => ['Docentes', 'Areamonografias', 'Tccestudantes']
                ];
            // die();
            endif;
        };

        if (!isset($busca)):

            $busca = $this->getRequest()->getSession()->read('busca');

            // die();
            if (!empty($busca)):
                $this->paginate = [
                    'conditions' => ['titulo LIKE' => "%" . $busca . "%"],
                    'contain' => ['Docentes', 'Areamonografias', 'Tccestudantes']
                ];
            else:
                $this->paginate = [
                    'contain' => ['Docentes', 'Areamonografias', 'Tccestudantes']
                ];
            endif;
        endif;

        $monografias = $this->paginate($this->Monografias);
        // debug($monografias);
        $this->set(compact('monografias'));
    }

    /**
     * Arquivo metodo
     *
     * @param array $dados.
     * @return $dados['url'].
     */
    private function arquivo($dados, $dre = null) {

        $this->Authorization->skipAuthorization();
        // pr($dados);
        if (empty($dados['registro'])):
            $dados['registro'] = $dre;
        endif;
        /* capturo o tipo de arquivo enviado a partir do servidor */
        /* Verificar error e tamanho do arquivo */
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['url']['tmp_name']);
        // pr($mime);
        // pr($_FILES['url']);
        // die();
        if ($mime == 'application/pdf'):
            $nome_arquivo = $dados['registro'] . '.' . 'pdf';
            // echo $nome_arquivo . '<br>';
            // die();
            move_uploaded_file($_FILES['url']['tmp_name'], WWW_ROOT . 'monografias/' . $nome_arquivo);
            // die();
            $dados['url'] = $nome_arquivo;
        // echo $dados['url'];
        // die();
        else:
            $this->Flash->error(__('Somente são permitidos arquivos PDF.'));
            return $this->redirect(['action' => 'add']);
        endif;

        return $dados['url'];
    }

    /**
     * Estudantes método
     *
     * @param array NULL.
     * @return array $estudantes
     */
    private function estudantes() {

        /* Preciso capturar o registro do estudante */
        $this->loadModel('Estudantes');
        $estudantes = $this->Estudantes->find('all');
        $estudantes->select(['registro', 'nome']);
        $estudantes->order(['nome' => 'asc']);
        // pr($estudantes);
        // die();

        /* Tenho que separar os estudantes que já tem TCC */
        foreach ($estudantes as $c_estudante):
            // pr($c_estudante);
            // die('estudante');
            $tcc = $this->Monografias->Tccestudantes->find('all');
            $tcc->where(['Tccestudantes.registro' => $c_estudante->registro]);
            $tcc->select(['registro', 'nome', 'monografia_id']);
            // pr($tcc->first());
            /* Estudantes sem TCC */
            if ($tcc->first()):
            // echo "Com monografia" . "<br>";
            // echo $tcc->first()->monografia_id . " ";
            // echo $tcc->first()->registro . " ";
            // echo $tcc->first()->nome . "<br>";
            else:
                // echo "Sem monografia ";
                $alunos[$c_estudante->registro] = $c_estudante->nome;
            // echo "<br>";
            endif;
            // echo "<br>";
        endforeach;
        // pr($alunos);
        // die();
        return $alunos;
        /* Fim da captura dos registro dos estudantes */
    }

    public function lista() {

        $this->Authorization->skipAuthorization();
        $path = WWW_ROOT . "/monografias/";
        $diretorio = dir($path);
        // die();
        $i = 0;
        $k = 0;
        // echo "Lista de arquivos do diretório '<strong>" . $path . "</strong>':<br />";
        while ($arquivo = $diretorio->read()) {
            // $lista[$k] = $arquivo;
            // die();
            $c_arquivo = explode('.', $arquivo);
            // echo "DRE " . $c_arquivo[0] . "<br>";
            if (!empty($c_arquivo['0'])):

                $pdfs = $this->Monografias->Tccestudantes->find('all', [
                    ['contain' => 'Monografias'],
                    ['fields' => ['Monografias.url', 'Tccestudantes.registro', 'Tccestudantes.id']]
                ]);
                $pdfs->where(['Tccestudantes.registro' => $c_arquivo[0]]);
                $monografias = $pdfs->first();
                if ($monografias):
                    $arquivospdf[$i]['pdf'] = $c_arquivo[0];
                    $arquivospdf[$i]['id'] = $monografias->id;
                    $arquivospdf[$i]['nome'] = $monografias->nome;
                    $arquivospdf[$i]['registro'] = $monografias->registro;
                // pr($monografias);
                // die();
                else:
                    $arquivospdf[$i]['pdf'] = $c_arquivo[0];
                    $arquivospdf[$i]['id'] = '';
                    $arquivospdf[$i]['nome'] = '';
                    $arquivospdf[$i]['registro'] = '';
                endif;
                $i++;
                $k++;
            endif;
        }
        $diretorio->close();
        sort($arquivospdf);
        // pr($lista);
        $this->set(compact('arquivospdf'));
        // die();
    }

    /*
     * Repara o valor do campo url da tabela Monografias em função dos PDF que há no folder 'monografias'
     */

    public function verificapdf() {

        $this->Authorization->skipAuthorization();
        $file_path = WWW_ROOT . 'monografias';
        $dir = new Folder($file_path);
        $files = $dir->find('.*\.pdf');
        $monografias = $this->Monografias->find('all', ['fields' => ['url', 'id']]);

        $i = 0;
        foreach ($monografias as $monografia):

            if ($monografia['url']):
                $valor = array_search($monografia['url'], $files, true);
                if ($valor):
                    echo 'exits ' . $monografia['url'] . "<br />";

                    $arraymonografia['url'] = $monografia['url'];
                    $arraymonografia['id'] = $monografia['id'];
                    $tcc = $this->Monografias->get($monografia['id']);

                    $atualizatcc = $this->Monografias->patchEntity($tcc, $arraymonografia);

                    if ($this->Monografias->save($atualizatcc)):
                        echo $i++ . " " . $arraymonografia['id'] . " atualizada" . "<br />";
                    endif;
                else:
                    $arraymonografia['url'] = null;
                    $arraymonografia['id'] = $monografia['id'];
                    $tcc = $this->Monografias->get($monografia['id']);

                    $atualizatcc = $this->Monografias->patchEntity($tcc, $arraymonografia);

                    if ($this->Monografias->save($atualizatcc)):
                        echo $i++ . " " . $arraymonografia['id'] . " atualizada" . "<br />";
                    endif;
                endif;

            else:
                $valor = null;
            endif;
            // pr($valor);
        endforeach;
        die();
    }

    /*
     * Altera o valor do campo url na tabela Monografias em função dos arquivos que estão no folder monografias
     */

    public function verificafilespdf() {

        $this->Authorization->skipAuthorization();
        $file_path = WWW_ROOT . 'monografias';
        $dir = new Folder($file_path);
        $files = $dir->find('.*\.pdf');
        echo $total = count($files) . "<br>";
        $i = 0;
        $this->loadModel("Tccestudantes");
        foreach ($files as $file):
            $parte = explode(".", $file);
            // echo $file . "<br />";
            $estudantes = $this->Tccestudantes->find();
            $estudantes->where(['registro' => $parte[0]]);
            $estudantes->select(['id', 'registro', 'monografia_id']);
            $estudantes->first();
            $estudantes->enableHydration(false);
            // debug($monografias);
            // die();
            $resultado_estudantes = $estudantes->toArray();
            // pr($resultado_estudantes);
            if (sizeof($resultado_estudantes) == 0):
                echo "Monografia não localizada na tabela Tccestudantes" . $file . '<br >';
            // die();
            else:
                $monografias = $this->Monografias->find();
                $monografias->where(['id' => $resultado_estudantes[0]['monografia_id']]);
                $monografias->select(['id', 'url']);
                $monografias->first();
                $monografias->enableHydration(false);
                $resultado_monografias = $monografias->toArray();
                // pr($resultado_monografias);

                if (empty($resultado_monografias[0]['url'])):

                    $arraymonografia['url'] = $file;
                    $arraymonografia['id'] = $resultado_monografias[0]['id'];
                    $tcc = $this->Monografias->get($resultado_monografias[0]['id']);
                    $atualizatcc = $this->Monografias->patchEntity($tcc, $arraymonografia);
                    // pr($atualizatcc);
                    // die('atualiza ' . $file);
                    if ($this->Monografias->save($atualizatcc)):
                        echo $i++ . " " . $arraymonografia['id'] . " " . $arraymonografia['url'] . " atualizada" . "<br />";
                    endif;
                endif;
            endif;
            $i++;
            // echo $i . " " . $file . "<br />";
        endforeach;
        die();
    }

    public function download($dre = null, $id = null) {

        $this->Authorization->skipAuthorization();
        $this->autoRender = false;
        // pr($dre);
        $file_path = WWW_ROOT . 'monografias';
        $dir = new Folder($file_path);
        $files = $dir->find('.*\.pdf');
        // echo $dir->realpath($file_path);
        // pr($files);
        foreach ($files as $file) {
            $file = new File($dir->pwd() . DS . $file);
            // pr($file->name . " " . $dre);
            // die();
            if ($file->name === $dre):
                // echo "Arquivo achado" . $file->name;
                // echo $file->name;
                echo '<a href=' . 'http://' . $_SERVER . '/monografias/' . $file->name . ' target=_blank download= ' . $file->name . '>Clique aqui</a>';
                // return $this->redirect(['action' => 'view', $id]);
                exit();
            endif;
        }
        echo $this->Flash->error(__('Arquivo ' . $dre . ' não encontrado'));
        return $this->redirect(['action' => 'view', $id]);
    }

}
