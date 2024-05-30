import { writeReply } from './Write_reply.js';
import { deletePost } from './Delete_post.js';

export function showLinks(pid) {
    const sideParagraph = document.createElement('p');
    sideParagraph.classList.add('side');

    fetch('../json/user.json')
        .then(response => response.json())
        .then(user_id => {
            if (user_id === 0) {
                const deleteLink = document.createElement('a');
                deleteLink.href = `#${pid}`;
                deleteLink.onclick = () => deletePost(pid);
                deleteLink.textContent = 'Delete';
                sideParagraph.appendChild(deleteLink);
                sideParagraph.appendChild(document.createTextNode(' | '));
            }

            if (user_id >= 0) {
                const replyLink = document.createElement('a');
                replyLink.href = `#${pid}`;
                replyLink.onclick = () => writeReply(pid);
                replyLink.textContent = 'Reply';
                sideParagraph.appendChild(replyLink);
            }

            fetch(`../json/replies${pid}.json`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        if (user_id >= 0) {
                            sideParagraph.appendChild(document.createTextNode(' | '));
                        }

                        const repliesLink = document.createElement('a');
                        repliesLink.href = `#${pid}`;
                        if (document.getElementById(`p${pid}`)) {
                            repliesLink.onclick = () => hideReplies(data, pid);
                            repliesLink.textContent = 'Hide replies';
                        } else {
                            repliesLink.onclick = () => drawDivs(data, pid);
                            repliesLink.textContent = 'Show replies';
                        }
                        sideParagraph.appendChild(repliesLink);
                    }
                })
                .catch(error => {
                    console.error('Error loading replies:', error);
                });
        })
        .catch(error => {
            console.error('Error loading user:', error);
        });

    const parentElement = document.getElementById(pid);
    parentElement.appendChild(sideParagraph);
}

function drawDivs(replies, pid) {
    const repliesDiv = document.createElement('div');
    repliesDiv.classList.add('replies');
    repliesDiv.id = `p${pid}`;
    const parentElement = document.getElementById(pid);
    parentElement.parentNode.insertBefore(repliesDiv, parentElement.nextSibling);
    replies.forEach(reply => {
        const replyDiv = document.createElement('div');
        replyDiv.classList.add('comment');
        replyDiv.id = reply.id;
        const sideParagraph = document.createElement('p');
        sideParagraph.classList.add('side');
        sideParagraph.textContent = `${reply.name} | ${reply.day} ${reply.month} ${reply.year} | ${reply.time} UTC`;
        replyDiv.appendChild(sideParagraph);
        const textParagraph = document.createElement('p');
        textParagraph.classList.add('text');
        textParagraph.textContent = reply.comment;
        replyDiv.appendChild(textParagraph);
        repliesDiv.appendChild(replyDiv);
    });
    replies.forEach(reply => {
        showLinks(reply.id);
    });
    hideRepliesLink(replies, pid);
}

function postDivs() {
    const postsFile = '../json/posts.json';
    const blogElement = document.getElementById('Blog');
    const commentsDiv = document.createElement('div');
    commentsDiv.classList.add('comments');
    commentsDiv.id = 'p0';
    blogElement.appendChild(commentsDiv);
    fetch(postsFile)
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                const commentDiv = document.createElement('div');
                commentDiv.classList.add('comment');
                commentDiv.id = item.id;
                const sideParagraph = document.createElement('p');
                sideParagraph.classList.add('side');
                sideParagraph.textContent = `${item.name} | ${item.day} ${item.month} ${item.year} | ${item.time} UTC`;
                commentDiv.appendChild(sideParagraph);
                const titleHeading = document.createElement('h3');
                titleHeading.classList.add('title');
                titleHeading.textContent = item.title;
                commentDiv.appendChild(titleHeading);
                const textParagraph = document.createElement('p');
                textParagraph.classList.add('text');
                textParagraph.textContent = item.comment;
                commentDiv.appendChild(textParagraph);
                commentsDiv.appendChild(commentDiv);
            });
            data.forEach(item => {
                showLinks(item.id);
            });
        })
        .catch(error => {
            console.error('Error loading posts:', error);
        });
}

postDivs();

// hide replies
function hideRepliesLink(replies, pid) {
    const comment = document.getElementById(pid);
    const lastChild = comment.lastChild;
    const hideRepliesLink = document.createElement('a');
    hideRepliesLink.href = '#' + pid;
    hideRepliesLink.onclick = () => hideReplies(replies, pid);
    hideRepliesLink.textContent = 'Hide replies';
    lastChild.replaceChild(hideRepliesLink, lastChild.lastChild);
}

function hideReplies(replies, pid) {
    const comment = document.getElementById(pid);
    const lastChild = comment.lastChild;
    const showRepliesLink = document.createElement('a');
    showRepliesLink.href = '#' + pid;
    showRepliesLink.onclick = () => drawDivs(replies, pid);
    showRepliesLink.textContent = 'Show replies';
    lastChild.replaceChild(showRepliesLink, lastChild.lastChild);
    const repliesDiv = document.getElementById(`p${pid}`);
    repliesDiv.remove();
}