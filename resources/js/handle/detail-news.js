import Viewer from '@toast-ui/editor/dist/toastui-editor-viewer';
import '@toast-ui/editor/dist/toastui-editor-viewer.css';

const xhr = new XMLHttpRequest();
xhr.open(
    'GET',
    articleContentUrl
);
xhr.onload = function () {
    if (xhr.status === 200) {
        const viewer = new Viewer({
            // // el: document.querySelector('#editor'), // The container element for the editor
            // // height: '500px',
            // initialEditType: 'wysiwyg', // Or 'wysiwyg'
            // // previewStyle: 'vertical'
            el: document.querySelector('#viewer'),
            initialValue: xhr.responseText
        });
    }
}
xhr.onerror = function () {
    document.querySelector('.news-content').innerHTML = 'Error fetching the data....';
}
xhr.send();
