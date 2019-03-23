/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.toolbarGroups = [
        { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
        { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
        { name: 'links' },
        { name: 'insert' },
        //{ name: 'forms' },
        { name: 'tools' },
        { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'others' },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
        { name: 'styles' },
        { name: 'colors' },
        { name: 'about' }
    ];
    /*config.toolbar = [
        [ 'Source'],
        [ 'Cut','Copy','Paste','PasteText','PasteFromWord','Print','-','SpellChecker','Scayt','-','Undo','Redo' ],
        [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','Smiley','SpecialChar' ,'PageBreak'],
        '/',
        [ 'NumberedList','BulletedList','-','Outdent','Indent','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl','-','Link','Unlink','Anchor','TextColor','BGColor','-','Image','Flash','Table','HorizontalRule'],        '/',
        [ 'Styles','Format','Font','FontSize'],
        [ 'Maximize'] 
    ];*/
    config.enterMode = CKEDITOR.ENTER_BR;
    config.autoParagraph = false;
	config.fillEmptyBlocks = function (element) {
            return true; // DON'T DO ANYTHING!!!!!
    };
	config.allowedContent = true;
};
