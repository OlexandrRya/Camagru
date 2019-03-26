document.addEventListener("DOMContentLoaded", function(event) {

    Array.from(document.getElementsByClassName('fa-heart')).forEach( (elem) => {
        elem.addEventListener('click', like)
    });

    Array.from(document.getElementsByClassName('fa-comments')).forEach( (elem) => {
        elem.addEventListener('click', comment)
    });

    Array.from(document.getElementsByClassName('add-comment')).forEach( (elem) => {
        elem.addEventListener('click', newComment)
    });

    Array.from(document.getElementsByClassName('fa-times-circle')).forEach( (elem) => {
        elem.addEventListener('click', removePhoto)
    });
});

function removePhoto(e) {
    let id = e.target.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('img')[0].id;
    let XHR = new XMLHttpRequest();
    let data = new FormData();
    data.append('photo_id', id);

    XHR.addEventListener('load', (event) => {

        e.target.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
    });

    XHR.open('POST', 'photo/remove');
    XHR.send(data);
}

function newComment(e) {
    const comment = e.target.parentNode.getElementsByTagName('input')[0];
    if (comment.value.length > 0) {
        const photoId = e.target.parentNode.parentNode.parentNode.getElementsByTagName('img')[0].id;
        sendComment(comment, photoId, e.target.parentNode.parentNode.getElementsByClassName('previous-comments')[0]);
    }
}

function sendComment (comment, photoId, e) {
    let XHR = new XMLHttpRequest();
    let data = new FormData();

    data.append('text', comment.value);
    data.append('photo_id', photoId);

    XHR.addEventListener('load', (event) => {
        let obj = JSON.parse(event.target.responseText);
        if (obj.status !== 'error' && obj.text.length > 0) {

            let commentDiv = document.createElement('div');
            commentDiv.setAttribute('class', 'comment');

            let userName = document.createElement('span');
            userName.setAttribute('class', 'user-name');
            userName.innerHTML = obj.user_name.concat(': ');

            let userComment = document.createElement('span');
            userComment.setAttribute('class', 'user-text');
            userComment.innerHTML = obj.text;

            e.appendChild(commentDiv);
            commentDiv.appendChild(userName);
            commentDiv.appendChild(userComment);
            comment.value = '';
        } else {

            let controlButton = comment.parentNode;

            if (controlButton.getElementsByClassName('error-text')[0])
                controlButton.getElementsByClassName('error-text')[0].remove();

            let error = document.createElement('p');
            error.setAttribute('class', 'error-text');
            error.innerHTML = obj.text;

            controlButton.appendChild(error);
        }

    });

    XHR.open('POST', 'comment/create');
    XHR.send(data)
}

function comment(e) {
    if (e.target.classList.contains('active-comment')) {
        e.target.classList.remove('active-comment');
        e.target.parentNode.parentNode.parentNode.parentNode.getElementsByClassName('comments-container')[0].classList.remove('active-comments-container');
    } else {
        e.target.classList.add('active-comment');
        e.target.parentNode.parentNode.parentNode.parentNode.getElementsByClassName('comments-container')[0].classList.add('active-comments-container');
    }
    e.stopPropagation();
    e.preventDefault();
}

function like(e) {

    const photoId = e.target.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('img')[0].id;
    let XHR = new XMLHttpRequest();
    let data = new FormData();
    data.append('photo_id', photoId);

    if (e.target.classList.contains('active-like')) {
        XHR.addEventListener('load', (event) => {
            let obj = JSON.parse(event.target.responseText);
            if (obj && obj.status !== 'error') {
                e.target.classList.remove('active-like');
                e.target.innerHTML = Number(e.target.innerHTML) - +1;
            }
        });

        XHR.open('POST', 'like/remove');
    } else {
        XHR.addEventListener('load', (event) => {
            let obj = JSON.parse(event.target.responseText);
            if (obj && obj.status !== 'error') {
                e.target.classList.add('active-like');
                e.target.innerHTML = Number(e.target.innerHTML) + +1;
            }
        });
        XHR.open('POST', 'like/create');
    }

    XHR.send(data);
    e.stopPropagation();
    e.preventDefault()
}
