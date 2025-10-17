import Editor from "@toast-ui/editor";
import "@toast-ui/editor/toastui-editor.css";

function getDefaultContent() {
    try {
        setDefaultContent(editor);
        return defaultContent;
    } catch (error) {
        return "";
    }
}

const editor = new Editor({
    el: document.querySelector("#editor"),
    height: "500px",
    placeholder: "Write something cool!",
    initialEditType: "wysiwyg",
    initialValue: getDefaultContent(),
});
getDefaultContent(editor);
const form_article = document.getElementById("management-form-news");

form_article
    .addEventListener("submit", (e) => {
        e.preventDefault();
    });

document
    .getElementById("btn-submit-news")
    .addEventListener("click", (e) => {
        const content = editor.getMarkdown();
        if (content) {
            document.getElementById(
                "tags_sender"
            ).innerHTML += `<textarea name="content" id="content_news">${content}</textarea>`;
            form_article.submit();
        } else {
            alert("Harap Pastikan Isi Artikel terisi");
        }
});
