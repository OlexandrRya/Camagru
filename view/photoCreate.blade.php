<div class="photo-div mr-top-l">
    <form action='#' method='POST' onsubmit='return false;'>
        <div id='video-div'>
            <video id='stream'>Stream not available</video>
            <div id='stick'><img src="" alt=""></div>
            <div class="photo-menu">
                <input id='upload-file' type="file" name="pic" accept="image/*">
                <input id='upload-submit' type="submit" value='Upload Photo'>
                <button id='photo-but'>Take photo</button>
                <div class='filters-wrapper'>
                    <select id='filters'>
                        <option value="none">Normal</option>
                        <option value="grayscale(100%)">Grayscale</option>
                        <option value="sepia(100%)">Sepia</option>
                        <option value="invert(100%)">Invert</option>
                        <option value="contrast(200%)">Contrast</option>
                    </select>
                </div>
                <button id='clear-but'>Clear</button>
            </div>
            <canvas id='canvas'></canvas>
        </div>
    </form>
    <div class="stick-div">
        <img class='stick-img' src="/public/image/stickers/samuel.png" alt="samuel sticker">
        <img class='stick-img' src="/public/image/stickers/dog.png" alt="Dog sticker">
        <img class='stick-img' src="/public/image/stickers/cat.png" alt="Cat sticker">
        <img class='stick-img' src="/public/image/stickers/bruce.png" alt="Bruce Lee sticker">
        <img class='stick-img' src="/public/image/stickers/hercules.png" alt="Hercules sticker">
        <img class='stick-img' src="/public/image/stickers/ufo.png" alt="UFO sticker">
        <img class='stick-img' src="/public/image/stickers/elon.png" alt="Elon Musk sticker">
        <img class='stick-img' src="/public/image/stickers/will.png" alt="Will Smith sticker">
    </div>
    <div class='bottom-container'>
        <div id='photos'></div>
    </div>
</div>

<div>

</div>

<style>
    body {
        margin: 0;
        padding: 0;
        overflow-y: hidden;
    }

    .photo-div {
        padding-top: 10px;
        display: flex;
        justify-content: center;
        flex-flow: wrap;
        width: 100%;
        height: 50%;
    }

    .bottom-container {
        height: 35%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #363636;
    }

    .bottom-container img {
        height: 350px;
        width: 500px;
    }

    #canvas {
        display: none;
    }

    #video-div {
        display: flex;
        flex-flow: column nowrap;
        justify-content: center;
        align-items: center;
        position: relative;
        margin-bottom: 80px;
    }

    .photo-menu {
        flex-flow: wrap;
        display: flex;
        align-items: center;
        height: 50px;
        width: 100%;
        padding: 10px;
    }

    #photo-but, #clear-but, #upload-file, #upload-submit {
        background-color: #009688;
        border: none;
        color: white;
        padding: 10px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        opacity: 0.8;
        transition: 0.3s;
        outline: 0;
        height: 40px;
        white-space: nowrap;
        width: auto;

    }

    #clear-but:hover, #photo-but:hover, #upload-file:hover, #upload-submit:hover {
        opacity: 1;
        cursor: pointer;
    }

    .stick-div
    {
        width: 200px;
        height: 550px;
        overflow-y: scroll;
        margin-left: 20px;
        user-select: none;
    }

    .stick-div img
    {
        width: 175px;
        height: 175px;
    }

    .stick-div img:hover {
        border: 2px solid #00D5B6;
        border-radius: 10px;
        cursor: pointer;
    }

    .stick-div::-webkit-scrollbar {
        width: 0.5em;
    }

    .stick-div::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 20px;
        border: 2px solid slategrey;
    }

    .stick-div::-webkit-scrollbar-thumb {
        background-color: #00D5B6;
        outline: 1px solid slategrey;
        border-radius: 20px;
        border: 2px solid slategrey;
    }

    .stick-div::-webkit-scrollbar-corner {
        border-radius: 20px;
        border: 2px solid red;
    }

    #stick {
        display: none;
        position: absolute;
        z-index: 100;
        top: 25%;
        left: 15%;
    }

    #stick img {
        width: 175px;
        height: 175px;
    }

    #upload-submit {
        padding-right: 0;
        padding-left: 0;
    }
</style>
<script>
    // Global variables
    let width = 600,
        height = 0,
        filter = 'none',
        streaming = false

    // DOM Elements
    const video = document.getElementById('stream')
    const canvas = document.getElementById('canvas')
    const photos = document.getElementById('photos')
    const photoButton = document.getElementById('photo-but')
    const clearButton = document.getElementById('clear-but')
    const filters = document.getElementById('filters')
    const stickers = document.getElementsByClassName('stick-div')[0]
    const uploadButton = document.getElementById('upload-submit')
    const uploadFile = document.getElementById('upload-file')


    function sendFile(file) {
        let XHR = new XMLHttpRequest()
        let data = new FormData()

        // adding data to the form
        data.append('file', file)

        // // get response from the server
        XHR.addEventListener('load', (event) => {
            if (event.target.responseText === 'success') {
                alert('Success')
            } else {
                alert('Invalid file')
            }
        })

        // send ajax request
        XHR.open('POST', '/photo/create/post')
        XHR.send(data)
    }

    function uploadPhoto(e) {

        if (uploadFile.files.length > 0) {
            sendFile(uploadFile.files[0])
        }

    }

    // Get media stream
    navigator.mediaDevices.getUserMedia({video: true, audio: false}
    ).then(function (stream) {
        // link to the video source
        video.srcObject = stream
        // Play the video
        video.play()
    })

        .catch ( function (err) {
            console.log(`error: ${err}`)
        })

    // Add event listener for click on sticker
    stickers.addEventListener('click', addStickerToCanvas)

    // Add event listener for click on upload file
    uploadButton.addEventListener('click', uploadPhoto)

    // Play when ready
    video.addEventListener('canplay', function (e) {
        if (!streaming) {
            // set video canvas height
            height = video.videoHeight / (video.videoWidth / width)

            video.setAttribute('width', width)
            video.setAttribute('height', height)
            canvas.setAttribute('width', width)
            canvas.setAttribute('height', height)

            streaming = true
        }
    }, false)

    // Photo button event
    photoButton.addEventListener('click', function (e) {
        takePicture()
        e.preventDefault()
    })

    //Filter event
    filters.addEventListener('change', function(e) {
        // Set filter to chosen options
        filter = e.target.value
        // Set filter to video
        video.style.filter = filter
        e.preventDefault()
    })

    //Clear event
    clearButton.addEventListener('click', function(e) {
        //Clear photos
        photos.innerHTML = ''
        //Change filter back to normal
        filter = 'none'
        // Set video filter
        video.style.filter = filter
        // Reset select list
        filters.selectedIndex = 0
        // Remove sticker from canvas
        const stickerDivOnCanvas = document.getElementById('stick')
        stickerDivOnCanvas.style.display = 'none'
    })

    // Take picture from canvas
    function takePicture() {
        const context = canvas.getContext('2d')
        if (width && height) {
            canvas.width = width
            canvas.height = height
            // Draw an image of the video
            context.drawImage(video, 0, 0, width, height)

            // create an image from the canvas
            const imgUrl = canvas.toDataURL('image/png')
            //console.log(imgUrl)
            // Create an img element
            const img = document.createElement('img')

            //Set img src
            img.setAttribute('src', imgUrl)

            // Set image filter
            img.style.filter = filter

            // send an image to php
            sendRequest(imgUrl)
        }
    }

    function sendRequest(imgUrl) {
        const stickerDivOnCanvas = document.getElementById('stick')
        const stickerImgOnCanvas = stickerDivOnCanvas.getElementsByTagName('img')[0]
        let div = document.getElementsByClassName('photo-div')
        let form = div[0].getElementsByTagName('form')
        let XHR = new XMLHttpRequest()
        let  formData = new FormData(form)


        formData.append('img', imgUrl)
        formData.append('filter', video.style.filter)
        if (stickerDivOnCanvas.style.display === 'flex') {
            formData.append('sticker', stickerImgOnCanvas.src)
        }
        XHR.addEventListener("load", function(event) {
            // console.log('an = > ', event.target.responseText)
            let obj = JSON.parse(event.target.responseText)

            // remove previous photo
            console.log(obj)
            let prevImg = document.getElementById('photo')
            if (prevImg) {
                photos.removeChild(prevImg)
            }
            // add image to photos
            let imgTag = document.createElement('img')
            imgTag.setAttribute('id', 'photo');
            imgTag.setAttribute('src', obj.path);
            photos.appendChild(imgTag)
        })
        XHR.open("POST", '/photo/create/snapshot-post');
        XHR.send(formData)
    }

    function addStickerToCanvas(e) {
        if (e.target.className === 'stick-img') {
            const stickerDivOnCanvas = document.getElementById('stick')
            const stickerImgOnCanvas = stickerDivOnCanvas.getElementsByTagName('img')[0]
            stickerImgOnCanvas.src = e.target.src
            stickerDivOnCanvas.style.display = 'flex'
        }
    }
</script>