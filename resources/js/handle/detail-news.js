import Viewer from '@toast-ui/editor/dist/toastui-editor-viewer';
import '@toast-ui/editor/dist/toastui-editor-viewer.css';

const viewer = new Viewer({
    el: document.querySelector('#viewer'),
    initialValue: ''
});
const setDefaultContent = (editor) => {
    const editorWrapper = document.getElementById('viewer');
    const loadingEditor = document.getElementById('loading-viewer');
    editorWrapper.style.display = 'none';
    fetch(articleContentUrl)
        .then(e => e.text())
        .then(text => {
            editor.setMarkdown(text);
        })
        .finally(() => {
            editorWrapper.style.display = 'block';
            loadingEditor.style.display = 'none';
        })
        .catch(error => console.error(error));
};

setDefaultContent(viewer);
