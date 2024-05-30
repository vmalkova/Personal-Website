import { showLinks } from "./Show_divs.js";

export function deletePost(id) {
    const form = document.createElement('form');
    form.id = `deleteForm${id}`;
    form.action = '../php/deletePost.php';
    form.method = 'post';

    const input = document.createElement('input');
    input.id = 'id';
    input.type = 'hidden';
    input.name = 'id';
    input.value = id;
    form.appendChild(input);

    const error = document.createElement('p');
    error.className = 'error';
    error.textContent = 'Are you sure you want to delete this post?';
    form.appendChild(error);

    const buttonRow = document.createElement('div');
    buttonRow.className = 'buttonRow';

    const deleteButton = document.createElement('button');
    deleteButton.id = 'delete';
    deleteButton.type = 'submit';
    deleteButton.textContent = 'Delete';
    buttonRow.appendChild(deleteButton);

    const cancelButton = document.createElement('button');
    cancelButton.id = 'cancel';
    cancelButton.textContent = 'Cancel';
    cancelButton.addEventListener('click', (e) => cancelDelete(id, e));
    buttonRow.appendChild(cancelButton);

    form.appendChild(buttonRow);

    const element = document.getElementById(id);
    element.replaceChild(form, element.lastChild);
}

function cancelDelete(id, e) {
    e.preventDefault();
    const form = document.getElementById(`deleteForm${id}`);
    form.remove();
    showLinks(id);
}