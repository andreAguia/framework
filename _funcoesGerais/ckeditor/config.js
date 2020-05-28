/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    config.toolbarGroups = [
        {name: 'document', groups: ['document', 'mode', 'doctools']},
        {name: 'styles', groups: ['styles']},
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['align', 'list', 'indent', 'blocks', 'bidi', 'paragraph']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'forms', groups: ['forms']},
        {name: 'colors', groups: ['colors']},
        {name: 'links', groups: ['links']},
        {name: 'insert', groups: ['insert']},
        {name: 'tools', groups: ['tools']},
        {name: 'others', groups: ['others']},
        {name: 'about', groups: ['about']}
    ];

    config.removeButtons = 'Form,Save,NewPage,Templates,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,BidiLtr,BidiRtl,Language,Anchor,Unlink,Link,Flash,Smiley,PageBreak,Iframe,FontSize,ShowBlocks,About,Maximize,Scayt,Source,Styles,Font,Copy,Cut,Undo,Redo,CreateDiv,Strike,Subscript,Superscript,Preview,Print';
};
