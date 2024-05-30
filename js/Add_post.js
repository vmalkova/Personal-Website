// post form validation
function removeError(input) {
    let errorP = input.nextElementSibling;
    if (errorP.nodeName === 'P') {
        errorP.remove();
    }
    if (input.classList.contains('red_text'))
    {
        input.classList.remove('red_text');
    }
}

function setErrorFor(input, message) {
    let errorText = document.createTextNode(message);
    let errorBox = document.createElement('p');
    errorBox.id = 'error';
    errorBox.appendChild(errorText);
    input.classList.add('red_text');
    input.after(errorBox);
}

function add (e)
{
    let title = document.getElementById('title');
    let comment = document.getElementById('comment');
    removeError(title);
    removeError(comment);
    if (title.value === '')
    {
        setErrorFor(title, 'Title cannot be blank');
    } 
    if (comment.value === '')
    {
        setErrorFor(comment, 'Comment cannot be blank');
    }
    if (title.value === '' || comment.value === '')
    {
        e.preventDefault();
        return;
    }
}

function clear(e)
{
    e.preventDefault();
    let title = document.getElementById('title');
    let comment = document.getElementById('comment');
    if (title.value === '' && comment.value === '')
    {
        return;
    }
    if (confirm("Are you sure you want to clear the form?"))
    {
        title.value = '';
        comment.value = '';
    }
}

function previewPost(e) {
    e.preventDefault();
    document.getElementById('AddPost').style.display = 'none';
    let userDateTime = document.getElementById('user_date_time').value;
    let title = document.getElementById('title').value;
    let comment = document.getElementById('comment').value;

    let postPreviewForm = document.createElement('form');
    postPreviewForm.id = 'postPreview';
    postPreviewForm.action = '../php/addPost.php';
    postPreviewForm.method = 'post';

    let postTitleInput = document.createElement('input');
    postTitleInput.type = 'hidden';
    postTitleInput.name = 'postTitle';
    postTitleInput.value = title;
    postPreviewForm.appendChild(postTitleInput);

    let postCommentInput = document.createElement('input');
    postCommentInput.type = 'hidden';
    postCommentInput.name = 'postComment';
    postCommentInput.value = comment;
    postPreviewForm.appendChild(postCommentInput);

    let commentDiv = document.createElement('div');
    commentDiv.classList.add('comment');

    let userDateTimeP = document.createElement('p');
    userDateTimeP.classList.add('side');
    userDateTimeP.textContent = userDateTime;
    commentDiv.appendChild(userDateTimeP);

    let titleH3 = document.createElement('h3');
    titleH3.classList.add('title');
    titleH3.textContent = title;
    commentDiv.appendChild(titleH3);

    let commentP = document.createElement('p');
    commentP.classList.add('text');
    commentP.textContent = comment;
    commentDiv.appendChild(commentP);

    let buttonRowDiv = document.createElement('div');
    buttonRowDiv.classList.add('buttonRow');

    let confirmPostButton = document.createElement('button');
    confirmPostButton.textContent = 'Post';
    buttonRowDiv.appendChild(confirmPostButton);

    let cancelPostButton = document.createElement('button');
    cancelPostButton.id = 'cancelPost';
    cancelPostButton.textContent = 'Cancel';
    cancelPostButton.addEventListener('click', cancelPost);
    buttonRowDiv.appendChild(cancelPostButton);

    postPreviewForm.appendChild(commentDiv);
    postPreviewForm.appendChild(buttonRowDiv);

    let commentsDiv = document.querySelector('.comments');
    commentsDiv.prepend(postPreviewForm);
}

function cancelPost(e){
    e.preventDefault();
    document.getElementById('postPreview').remove();
    document.getElementById('AddPost').style.display = 'block';
}

if (document.getElementById('clear') !== null) {
    document.getElementById('clear').addEventListener('click', clear);
}
if (document.getElementById('post') !== null) {
    document.getElementById('post').addEventListener('click', add);
}
if (document.getElementById('preview') !== null) {
    document.getElementById('preview').addEventListener('click', previewPost);
}