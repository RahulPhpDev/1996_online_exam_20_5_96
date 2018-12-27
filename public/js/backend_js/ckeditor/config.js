/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {

	config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'forms' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'tools' },
		{ name: 'others' },
		// { name: 'about' },
		// { name: 'wiris',  groups : [ 'ckeditor_wiris_formulaEditor','ckeditor_wiris_formulaEditorChemistry'] } 
	];


config.removePlugins = 'Copy,Quote,Remove,elementspath,save,flash,iframe,link,smiley,tabletools,find,pagebreak,templates,about,maximize,showblocks,newpage,language';

config.removeButtons = 'Quote,Copy,Remove,Block,Radio,Preview,Outdent,Indent,HorizontalRule,SpecialChar,BidiLtr,BidiRtl,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,Textarea,Button,SelectAll,NumberedList,BulletedList,CreateDiv,Table,PasteText,PasteFromWord,Select,HiddenField,Strike,Subscript,Superscript,Save,Flash,Checkbox,New Page, Preview,Templates,Find,Replace,Checkbox,Radio Button,Align,Align Left,Align Right,Center,Justify,Increase Indent,Link,Anchor,Flash';

config.resize_maxWidth = 780;
config.resize_maxHeight = 350;


config.filebrowserUploadUrl = '/upload_image';


	config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'ckeditor_wiris';
	config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'filebrowser';
   config.allowedContent = {
       $1: {
           // Use the ability to specify elements as an object.
           elements: CKEDITOR.dtd,
           attributes: true,
           styles: true,
           classes: true
       }
   };
   config.disallowedContent = '*{font*}; *{margin*}; *{color*}; span;';
		config.language = 'en';
		config.uiColor = '#AADC6E';  
	   config.height = '35vh';
	   config.resize_dir = 'both';
	//    config.resize_minHeight = 800;
	//    config.resize_enabled = true;
	//    config.resize_minWidth = 300;
	//    config.resize_minHeight = 300;
	

};

