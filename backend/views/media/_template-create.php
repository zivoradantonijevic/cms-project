<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */
?>
<script id="template-upload" type="text/x-tmpl">
{% if (o.files) { %}
   {% for (var i=0, file; file=o.files[i]; i++) { %}
        <div class="template-upload fade clearfix">
            <div class="media-preview-wrap clearix">
                <span class="media-preview preview"></span>
                <div class="media-filename-wrap">
                    <p class="media-filename">{%=file.name%}</p>
                    <strong class="error text-danger"></strong>
                </div>
            </div>
            <div class="media-progressbar">
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                    aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </div>
        </div>
    {% } %}
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% if (o.files) { %}
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <div class="template-download fade clearfix">
            <div class="media-preview-wrap clearfix">
                {% if (file.icon_url) { %}
                    <a class="media-preview" href="{%=file.update_url%}" title="{%=file.title%}">
                        <img src="{%=file.icon_url%}">
                    </a>
                {% } %}
                <div class="media-filename-wrap">
                    <p>
                        <span>{%=file.filename%}</span>
                        <br /><span class="size">{%=file.readable_size%}</span>
                    </p>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </div>
            </div>
            <div class="media-option">
                {% if (file.update_url) { %}
                    <a class="btn btn-flat btn-success edit" href={%=file.update_url%}>
                        <i class="glyphicon glyphicon-pencil"></i>
                        <span>Edit</span>
                    </a>
                {% } %}
                {% if (file.delete_url) { %}
                    <button class="btn btn-flat btn-danger delete" data-type="post" data-url="{%=file.delete_url%}">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                {% } %}
                {% if (file.error) { %}
                   <button class="btn btn-flat btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </div>
        </div>
    {% } %}
{% } %}
</script>
