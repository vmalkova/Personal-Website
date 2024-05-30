import { showLinks } from "./Show_divs.js";

export function writeReply(pid) {
    const existingFormPid = document.getElementById('formPid');
    if (existingFormPid) {
        const pid = existingFormPid.value;
        removeForm(pid);
    }

    const form = document.createElement('form');
    form.id = `form${pid}`;
    form.action = '../php/insertReply.php';
    form.method = 'POST';

    const closeLink = document.createElement('a');
    closeLink.href = `#${pid}`;
    closeLink.onclick = () => removeForm(pid);
    closeLink.className = 'closeReply';
    closeLink.textContent = '×';
    form.appendChild(closeLink);

    const replyInput = document.createElement('input');
    replyInput.id = 'replyComment';
    replyInput.type = 'text';
    replyInput.name = 'replyComment';
    replyInput.placeholder = 'Comment';
    form.appendChild(replyInput);

    const pidInput = document.createElement('input');
    pidInput.id = 'formPid';
    pidInput.type = 'hidden';
    pidInput.name = 'pid';
    pidInput.value = pid;
    form.appendChild(pidInput);

    const errorParagraph = document.createElement('p');
    errorParagraph.id = `error${pid}`;
    errorParagraph.className = 'error';
    form.appendChild(errorParagraph);

    const buttonRow = document.createElement('div');
    buttonRow.className = 'buttonRow';
    form.appendChild(buttonRow);

    const postButton = document.createElement('button');
    postButton.id = 'post_reply';
    postButton.type = 'submit';
    postButton.textContent = 'Reply';
    postButton.addEventListener('click', (e) => postReply(e, pid));
    buttonRow.appendChild(postButton);

    const clearButton = document.createElement('button');
    clearButton.id = 'clear_reply';
    clearButton.textContent = 'Clear';
    clearButton.addEventListener('click', clearReply);
    buttonRow.appendChild(clearButton);

    const element = document.getElementById(pid);
    element.replaceChild(form, element.lastChild);
}

function removeForm(pid) {
    const form = document.getElementById(`form${pid}`);
    form.remove();
    showLinks(pid);
}

function clearReply(e) {
    e.preventDefault();
    if (confirm('Are you sure you want to clear your reply?')) {
        document.getElementById('replyComment').value = '';
    }
}

function postReply(e, pid)
{
    const replyComment = document.getElementById('replyComment');
    if (replyComment.value === '') {
        e.preventDefault();
        const error = document.getElementById(`error${pid}`);
        error.textContent = 'Your reply can’t be empty';
    }
}


