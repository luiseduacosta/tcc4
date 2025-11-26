<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Routing\Router;
use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Monografias Controller
 *
 * @property \App\Model\Table\MonografiasTable $Monografias
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\TableRegistry $Monografias
 * @property \Cake\ORM\TableRegistry $Docentes
 * @property \Cake\ORM\TableRegistry $Areamonografias
 * @property \Cake\ORM\TableRegistry $Tccestudantes
 * 
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MonografiasController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
        // $this->Authorization->skipAuthorization();
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'busca', 'download']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $this->Authorization->skipAuthorization();
        if (isset($this->request->getData()['titulo'])) {
            $titulo = $this->request->getData()['titulo'];
            $query = $this->Monografias->find()
                ->where(['titulo LIKE' => "%" . $titulo . "%"])
                ->contain(['Docentes', 'Areamonografias', 'Tccestudantes']);
        } else {
            $query = $this->Monografias->find()
                ->contain(['Docentes', 'Areamonografias', 'Tccestudantes']);
        }
        if ($this->request->getQuery('sort') === null) {
            $query->order(['Monografias.titulo' => 'ASC']);
        }
        $monografias = $this->paginate($query, [
            'sortableFields' => [
                'Monografias.titulo',
                'Monografias.periodo',
                'Monografias.url',
                'Tccestudantes.nome',
                'Docentes.nome',
                'Areamonografias.area'
            ]
        ]);

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
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        try  {
            $monografia = $this->Monografias->get($id, [
                'contain' => ['Docentes', 'Docentes1', 'Docentes2', 'Docentes3', 'Areamonografias', 'Tccestudantes'],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Monografia não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
        // pr($monografia);
        // die();
        $this->Authorization->authorize($monografia);
        $baseUrl = Router::url('/', true);
        $this->set(compact('monografia', 'baseUrl'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $monografia = $this->Monografias->newEmptyEntity();
        // pr($monografia);
        // die();
        $this->Authorization->authorize($monografia);

        if ($this->request->is('post')) {

            $dados = $this->request->getData();
            
            /* Verifica se o arquivo foi enviado com a function arquivo() */
            $uploadedFile = $this->request->getUploadedFile('url');
            if ($uploadedFile instanceof \Psr\Http\Message\UploadedFileInterface && $uploadedFile->getError() === UPLOAD_ERR_OK):
                $dre = $dados['registro'];            
                $dados['url'] = $this->arquivo($uploadedFile, $dre);
            endif;
            /* Ajusto o periodo agregando ano e semestre */
            if (empty($dados['ano'])):
                $dados['ano'] = date('Y');
            endif;
            if (empty($dados['semestre'])):
                $dados['semestre'] = 1;
            endif;
            $periodo = $dados['ano'] . "-" . $dados['semestre'];
            $dados['periodo'] = $periodo;

            /* Banca1 é o próprio docente orientador */
            if (empty($dados['banca1'])):
                $dados['banca1'] = $dados['professor_id'] ?? null;
            endif;

            $monografia = $this->Monografias->patchEntity($monografia, $dados);
            $this->Authorization->authorize($monografia);
            if ($this->Monografias->save($monografia)) {
                $this->Flash->success(__('Monografia inserida.'));

                /* Tem que inserir o Tccestudante */
                $tccestudante = $this->Monografias->Tccestudantes->newEmptyEntity();

                /* Capturo o nome do estudante */
                $estudante = $this->fetchTable('Estudantes')
                    ->find()
                    ->where(['registro' => $dados['registro']])
                    ->select(['nome'])
                    ->first();

                /* Array com os dados para inserir */
                $dadosestudante['monografia_id'] = $monografia->id;
                $dadosestudante['registro'] = $dados['registro'];
                $dadosestudante['nome'] = $estudante->nome;
                // pr($dadosestudante);
                // die('dadosestudante');
                $tccestudante = $this->Monografias->Tccestudantes->patchEntity($tccestudante, $dadosestudante);
                if ($this->Monografias->Tccestudantes->save($tccestudante)) {
                    $this->Flash->success(__('Estudante de TCC inserido.'));
                    return $this->redirect(['controller' => 'Monografias', 'action' => 'view', $monografia->id]);
                }
                $this->Flash->error(__('Estudante de TCC não foi inserido.'));
            }
            $this->Flash->error(__('Monografia não foi inserida. Verifique que o nome do arquivo seja válido (sem espaços ou caracteres especiais). Tente novamente.'));
        }

        /* Chamo a function estudantes() para fazer o list de seleção */
        $estudantes = $this->estudantes();

        /* Deveria ser somente para Docentes não falecidos */
        $docentes = $this->Monografias->Docentes->find('list', [
            'keyField' => 'id', 
            'valueField' => 'nome',
            'order' => ['nome' => 'asc']
        ]);
        // $docentes->where(['dataegresso IS NULL']); // Deveria ser somente para Docentes não falecidos

        $areamonografias = $this->Monografias->Areamonografias->find('list', [
            'keyField' => 'id',
            'valueField' => 'area',
            'order' => ['area' => 'asc']
        ]);
        $this->set(compact('estudantes', 'monografia', 'docentes', 'areamonografias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Monografia id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $this->Authorization->skipAuthorization();
        try {
            $monografia = $this->Monografias->get($id, [
                'contain' => ['Docentes', 'Docentes1', 'Docentes2', 'Docentes3', 'Areamonografias', 'Tccestudantes'],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Monografia não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($monografia);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $dados = $this->request->getData();
//            $uploadedFile = $this->request->getUploadedFile('url');
//            if ($uploadedFile && $uploadedFile->getSize() > 0):
//                $dados['url'] = $this->arquivo($uploadedFile, $monografia->registro);
//            elseif (!empty($dados['url_atual'])):
//                $dados['url'] = $dados['url_atual'];
//            else:
//                $dados['url'] = null;
//            endif;

            $monografia = $this->Monografias->patchEntity($monografia, $dados);
            //pr($dados);
            // pr($monografia);
            // die();
            if ($this->Monografias->save($monografia)) {
                // debug($monografia);
                $this->Flash->success(__('Monografia atualizada.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            // debug($monografia);
            $this->Flash->error(__('Monografia não foi atualizada.'));
        }

        $docentes = $this->Monografias->Docentes->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => ['nome' => 'asc']
        ]);

        $areamonografias = $this->Monografias->Areamonografias->find('list', [
            'keyField' => 'id',
            'valueField' => 'area',
            'order' => ['area' => 'asc']
        ]);

        $this->set(compact('monografia', 'docentes', 'areamonografias'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Monografia id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);

        try {
            $monografia = $this->Monografias->get($id);
            $this->Authorization->authorize($monografia);
            if ($this->Monografias->delete($monografia)) {
                $this->Flash->success(__('Monografia excluída.'));
            } else {
                $this->Flash->error(__('Monografia não foi excluída.'));
            }
        } catch (\Exception $e) {
            $this->Flash->error(__('Monografia não foi excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Arquivo metodo
     *
     * @param \Psr\Http\Message\UploadedFileInterface $uploadedFile
     * @param string $dre
     * @return string|null
     */
    private function arquivo($uploadedFile, $dre)
    {
        $this->Authorization->skipAuthorization();
        $mime = $uploadedFile->getClientMediaType();

        if ($mime == 'application/pdf') {
            $nome_arquivo = $dre . '.pdf';
            $uploadedFile->moveTo(WWW_ROOT . 'monografias/' . $nome_arquivo);
            return $nome_arquivo;
        } else {
            $this->Flash->error(__('Somente são permitidos arquivos PDF.'));
            return null;
        }
    }

    /**
     * Estudantes método
     *
     * @param array NULL.
     * @return array $estudantes
     */
    private function estudantes()
    {

        /* Capturar o registro do estudante */
        $estudantetable = $this->fetchTable('Alunos');
        $estudantes = $estudantetable->find('all');
        $estudantes->select(['registro', 'nome']);
        $estudantes->order(['nome' => 'asc']);

        /** Separar os estudantes que já fizeram TCC */
        foreach ($estudantes as $c_estudante):
            $tcc = $this->Monografias->Tccestudantes->find('all');
            $tcc->where(['Tccestudantes.registro' => $c_estudante->registro]);
            $tcc->select(['registro', 'nome', 'monografia_id']);
            /* Estudantes sem TCC */
            if ($tcc->first()):
            else:
                $alunos[$c_estudante->registro] = $c_estudante->nome;
            endif;
        endforeach;
        return $alunos;
    }

    public function lista()
    {

        $this->Authorization->skipAuthorization();
        $path = WWW_ROOT . "/monografias/";
        $diretorio = dir($path);
        $i = 0;
        $k = 0;
        while ($arquivo = $diretorio->read()) {
            $lista[$k] = $arquivo;
            $c_arquivo = explode('.', $arquivo);
            if (!empty($c_arquivo['0'])):

                $pdfs = $this->Monografias->Tccestudantes->find('all', [
                    'contain' => 'Monografias',
                    'fields' => ['Monografias.url', 'Tccestudantes.registro', 'Tccestudantes.id']
                ]);
                $pdfs->where(['Tccestudantes.registro' => $c_arquivo[0]]);
                $monografias = $pdfs->first();
                if ($monografias):
                    $arquivospdf[$i]['pdf'] = $c_arquivo[0];
                    $arquivospdf[$i]['id'] = $monografias->id;
                    $arquivospdf[$i]['nome'] = $monografias->nome;
                    $arquivospdf[$i]['registro'] = $monografias->registro;
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
        $this->set(compact('arquivospdf'));
    }

    /*
     * Repara o valor do campo url da tabela Monografias em função dos PDF que há no folder 'monografias'
     */

    public function verificapdf()
    {

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
    }

    /*
     * Altera o valor do campo url na tabela Monografias em função dos arquivos que estão no folder monografias
     */

    public function verificafilespdf()
    {

        $this->Authorization->skipAuthorization();
        $file_path = WWW_ROOT . 'monografias';
        $dir = new Folder($file_path);
        $files = $dir->find('.*\.pdf');
        echo $total = count($files) . "<br>";
        $i = 0;
        $tccestudantetable = $this->fetchTable("Tccestudantes");
        foreach ($files as $file):
            $parte = explode(".", $file);
            // echo $file . "<br />";
            $estudantes = $tccestudantetable->find();
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
        endforeach;
    }

    public function download($dre, $id)
    {

        $this->Authorization->skipAuthorization();
        $this->autoRender = false;
        $file_path = WWW_ROOT . 'monografias';
        $dir = new Folder($file_path);
        $files = $dir->find('.*\.pdf');
        foreach ($files as $file) {
            $file = new File($dir->pwd() . DS . $file);
            if ($file->name === $dre):
                echo '<a href=' . 'http://' . $_SERVER . '/monografias/' . $file->name . ' target=_blank download= ' . $file->name . '>Clique aqui</a>';
                exit();
            endif;
        }
        $this->Flash->error(__('Arquivo ' . $dre . ' não encontrado'));
        return $this->redirect(['action' => 'view', $id]);
    }
}
