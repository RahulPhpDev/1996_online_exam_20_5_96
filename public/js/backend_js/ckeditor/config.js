/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for a single toolbar row.
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

	// config.toolbar_Full.push({ name: 'wiris', items : [ 'ckeditor_wiris_formulaEditor','ckeditor_wiris_formulaEditorChemistry']});

	// The default plugins included in the basic setup define some buttons that
	// are not needed in a basic editor. They are removed here.
	// config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Strike,Subscript,Superscript';

	// Dialog windows are also simplified.
	// config.removeDialogTabs = 'link:advanced';
// config.removeButtons = 'Source,Cut,Copy,Paste,Undo,Redo,Anchor,Strike,Subscript,Superscript,Save,Flash';


config.removePlugins = 'elementspath,save,flash,iframe,link,smiley,tabletools,find,pagebreak,templates,about,maximize,showblocks,newpage,language';
// Checkbox,
// config.filebrowserBrowseUrl = '/browser/browse.php';
// config.filebrowserFlashBrowseUrl = '/browser/browse.php?type=Flash';
// config.filebrowserBrowseUrl = '/browser/browse.php';
// config.filebrowserUploadUrl = '/upload?type=Files';

config.removeButtons = 'Radio,Preview,Outdent,Indent,HorizontalRule,SpecialChar,BidiLtr,BidiRtl,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,Textarea,Button,SelectAll,NumberedList,BulletedList,CreateDiv,Table,PasteText,PasteFromWord,Select,HiddenField,Strike,Subscript,Superscript,Save,Flash,Checkbox,New Page, Preview,Templates,Find,Replace,Checkbox,Radio Button,Align,Align Left,Align Right,Center,Justify,Increase Indent,Link,Anchor,Flash';

// var path = CKEDITOR.basePath.split('/');
// path[ path.length-2 ] = 'upload_image';
config.filebrowserUploadUrl = '/upload_image';

// config.extraPlugins = 'filebrowser';

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

