import Editor from '@toast-ui/editor'
import '@toast-ui/editor/toastui-editor.css'

const editor = new Editor({
  el: document.querySelector('#editor'),
  height: '500px',
  placeholder: 'Write something cool!',
  initialEditType: 'wysiwyg'
});

document.getElementById('btn-submit-news').addEventListener('click', () => {
    console.log(editor)
    console.log(editor.getMarkdown());
})