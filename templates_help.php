<?php
//Sobrecribe los templates usados por FormHelper
return [
    // Used for checkboxes in checkbox() and multiCheckbox().
    'checkbox' => '<input type="checkbox" class="form-check-input" name="{{name}}" value="{{value}}"{{attrs}}>',
    // Input group wrapper for checkboxes created via control().
    'checkboxFormGroup' => '{{label}}',
    // Wrapper container for checkboxes.
    'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
    // Error message wrapper elements.
    'error' => '<div class="invalid-feedback">{{content}}</div>',
    // General grouping container for control(). Defines input/label ordering.
    'formGroup' => '{{prepend}}{{label}}{{input}}',
    // Container element used by control().
    'inputContainer' => '<div class="md-form{{required}}">{{content}}</div>',
    // Container element used by control() when a field has an error.
    'inputContainerError' => '<div class="md-form">{{content}}{{error}}</div>',
    // Label element when inputs are not nested inside the label.
    'label' => '<label class="mdb-main-label" {{attrs}}>{{text}}</label>',
    // Label element used for radio and multi-checkbox inputs.
    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
    // Multi-select element,
    'selectMultiple' => '<select name="{{name}}[]" class="mdb-select colorful-select dropdown-primary md-form" multiple {{attrs}} searchable="Filtrar...">{{content}}</select>',
];

return [
        'formStart' => '<form class="form-horizontal" {{attrs}}>',
        'legend' => '<legend>{{text}}</legend>',
        'inputContainerError' => '<div class="input {{class}} {{type}}{{required}} error">{{content}}{{error}}</div>',
        'inputContainer'=>'<div class="form-group">
                    <label class="col-md-4 control-label">{{legend}}</label>
                    <div class="col-md-8">{{content}}</div></div>',
        'input'=>'<input type="{{type}}" name="{{name}}" class="form-control input-small" {{attrs}} />',
        'submitContainer'=>'<div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            {{content}}
                        </div>
                    </div>
                </div>',
        'select' => '<div class="form-group">
                    <label class="col-md-4 control-label" {{attrs}}>{{legend}}</label>
                    <div class="col-md-8"><select class="form-control input medium" name="{{name}}"{{attrs}}>{{content}}</select></div></div>',
        'label' => '<label class="col-md-4 control-label" {{attrs}}>{{text}}{{label}}</label>',

];
