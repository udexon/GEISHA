let utils = new Utils('errorMessage');

let streaming = false;
let videoInput = document.getElementById('videoInput');
let startAndStop = document.getElementById('startAndStop');
let canvasOutput = document.getElementById('canvasOutput');
let canvasContext = canvasOutput.getContext('2d');
let info = document.getElementById('info');
let size = document.getElementById('size');

startAndStop.addEventListener('click', () => {
    if (!streaming) {
        utils.clearError();
        utils.startCamera(size.value, onVideoStarted, 'videoInput');
    } else {
        utils.stopCamera();
        onVideoStopped();
    }
});

function onVideoStarted() {
    streaming = true;
    startAndStop.innerText = 'Stop';
    videoInput.width = videoInput.videoWidth;
    videoInput.height = videoInput.videoHeight;
  startProcessing();
}

function onVideoStopped() {
    streaming = false;
    // canvasContext.clearRect(0, 0, canvasOutput.width, canvasOutput.height);
    startAndStop.innerText = 'Start';
}

utils.loadOpenCv(() => {
    startAndStop.removeAttribute('disabled');
});

function Utils(errorOutputId) { // eslint-disable-line no-unused-vars
    let self = this;
    this.errorOutput = document.getElementById(errorOutputId);

    const OPENCV_URL = 'https://docs.opencv.org/3.4/opencv.js';
    this.loadOpenCv = function(onloadCallback) {
        let script = document.createElement('script');
        script.setAttribute('async', '');
        script.setAttribute('type', 'text/javascript');
        script.addEventListener('load', () => {
            console.log(cv.getBuildInformation());
            onloadCallback();
        });
        script.addEventListener('error', () => {
            self.printError('Failed to load ' + OPENCV_URL);
        });
        script.src = OPENCV_URL;
        let node = document.getElementsByTagName('script')[0];
        node.parentNode.insertBefore(script, node);
    };

    this.createFileFromUrl = function(path, url, callback) {
        let request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.responseType = 'arraybuffer';
        request.onload = function(ev) {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    let data = new Uint8Array(request.response);
                    cv.FS_createDataFile('/', path, data, true, false, false);
                    callback();
                } else {
                    self.printError('Failed to load ' + url + ' status: ' + request.status);
                }
            }
        };
        request.send();
    };

    this.loadImageToCanvas = function(url, cavansId) {
        let canvas = document.getElementById(cavansId);
        let ctx = canvas.getContext('2d');
        let img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = function() {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0, img.width, img.height);
        };
        img.src = url;
    };

    this.executeCode = function(textAreaId) {
        try {
            this.clearError();
            let code = document.getElementById(textAreaId).value;
            eval(code);
        } catch (err) {
            this.printError(err);
        }
    };

    this.clearError = function() {
        this.errorOutput.innerHTML = '';
    };

    this.printError = function(err) {
        if (typeof err === 'undefined') {
            err = '';
        } else if (typeof err === 'number') {
            if (!isNaN(err)) {
                if (typeof cv !== 'undefined') {
                    err = 'Exception: ' + cv.exceptionFromPtr(err).msg;
                }
            }
        } else if (typeof err === 'string') {
            let ptr = Number(err.split(' ')[0]);
            if (!isNaN(ptr)) {
                if (typeof cv !== 'undefined') {
                    err = 'Exception: ' + cv.exceptionFromPtr(ptr).msg;
                }
            }
        } else if (err instanceof Error) {
            err = err.stack.replace(/\n/g, '<br>');
        }
        this.errorOutput.innerHTML = err;
    };

    this.loadCode = function(scriptId, textAreaId) {
        let scriptNode = document.getElementById(scriptId);
        let textArea = document.getElementById(textAreaId);
        if (scriptNode.type !== 'text/code-snippet') {
            throw Error('Unknown code snippet type');
        }
        textArea.value = scriptNode.text.replace(/^\n/, '');
    };

    this.addFileInputHandler = function(fileInputId, canvasId) {
        let inputElement = document.getElementById(fileInputId);
        inputElement.addEventListener('change', (e) => {
            let files = e.target.files;
            if (files.length > 0) {
                let imgUrl = URL.createObjectURL(files[0]);
                self.loadImageToCanvas(imgUrl, canvasId);
            }
        }, false);
    };

    function onVideoCanPlay() {
        if (self.onCameraStartedCallback) {
            self.onCameraStartedCallback(self.stream, self.video);
        }
    };

    this.startCamera = function(resolution, callback, videoId) {
        const constraints = {
            'qvga': {width: {exact: 320}, height: {exact: 240}},
            'vga': {width: {exact: 640}, height: {exact: 480}},
            'hd': {width: {exact: 1280}, height: {exact: 720}}};
        let video = document.getElementById(videoId);
        if (!video) {
            video = document.createElement('video');
        }

        let videoConstraint = constraints[resolution];
        if (!videoConstraint) {
            videoConstraint = true;
        }

        navigator.mediaDevices.getUserMedia({video: videoConstraint, audio: false})
            .then(function(stream) {
                video.srcObject = stream;
                video.play();
                self.video = video;
                self.stream = stream;
                self.onCameraStartedCallback = callback;
                video.addEventListener('canplay', onVideoCanPlay, false);
            })
            .catch(function(err) {
                self.printError('Camera Error: ' + err.name + ' ' + err.message);
            });
    };

    this.stopCamera = function() {
        if (this.video) {
            this.video.pause();
            this.video.srcObject = null;
            this.video.removeEventListener('canplay', onVideoCanPlay);
        }
        if (this.stream) {
            this.stream.getVideoTracks()[0].stop();
        }
    };
};

function startProcessing() {
  let video = document.getElementById('videoInput');
  let src = new cv.Mat(video.height, video.width, cv.CV_8UC4);
  let dst = new cv.Mat(video.height, video.width, cv.CV_8UC1);
  let cap = new cv.VideoCapture(video);

  const FPS = 30;
  const WARMUPS = 10;
  let warming = true;
  let frames = 0;
  let totalFrames = 0;
  let videoCapTotal = 0;
  let videoCapMax = 0;
  let videoCapMin = 1000;
  let processTotal = 0;
  let processMax = 0;
  let processMin = 1000;
  let imshowTotal = 0;
  let imshowMax = 0;
  let imshowMin = 1000;
  let overheadTotal = 0;
  let overheadMin = 1000;
  let overheadMax = 0;
  function processVideo() {
      try {
          if (!streaming) {
              // clean and stop.
              src.delete();
              dst.delete();
              let videoCapAvg = videoCapTotal/totalFrames;
              let processAvg = processTotal/totalFrames;
              let imshowAvg = imshowTotal/totalFrames;
              let overheadAvg = overheadTotal/totalFrames
              info.innerHTML = `frames: ${frames}<br>
overhead avg: ${overheadAvg.toFixed(2)}ms min: ${overheadMin.toFixed(2)}ms max: ${overheadMax.toFixed(2)}ms<br>
videoCap avg: ${videoCapAvg.toFixed(2)}ms min: ${videoCapMin.toFixed(2)}ms max: ${videoCapMax.toFixed(2)}ms<br>
process avg: ${processAvg.toFixed(2)}ms min: ${processMin.toFixed(2)}ms max: ${processMax.toFixed(2)}ms<br>
imshow avg: ${imshowAvg.toFixed(2)}ms min: ${imshowMin.toFixed(2)}ms max: ${imshowMax.toFixed(2)}ms`;
              return;
          }
          frames++;
          if (frames > 10) warming = false;
          let begin = performance.now();
          let start = begin;
          // start processing.
          cap.read(src);
          let videoCapTime = performance.now() - begin;
          if (!warming) {
            videoCapTotal += videoCapTime;
            if (videoCapMax < videoCapTime) videoCapMax = videoCapTime;
            if (videoCapMin > videoCapTime) videoCapMin = videoCapTime;
          }
          begin = performance.now();
          cv.cvtColor(src, dst, cv.COLOR_RGBA2GRAY);
          let processTime = performance.now() - begin;
          if (!warming) {
            processTotal += processTime;
            if (processMax < processTime) processMax = processTime;
            if (processMin > processTime) processMin = processTime;
          }
          begin = performance.now();

          // cv.imshow('canvasOutput', dst);
          cv.imshow('canvasOutput', src);
          
          let imshowTime = performance.now() - begin;
          // schedule the next one.
          if (!warming) {
            imshowTotal += imshowTime;
            if (imshowMax < imshowTime) imshowMax = imshowTime;
            if (imshowMin > imshowTime) imshowMin = imshowTime;
          }
          let overhead = performance.now() - start;
          if (!warming) {
            overheadTotal += overhead;
            if (overheadMax < overhead) overheadMax = overhead;
            if (overheadMin > overhead) overheadMin = overhead;
          }
          if (!warming) {
            totalFrames++;
            info.innerHTML = `frames: ${totalFrames}, videoCap: ${videoCapTime.toFixed(2)}ms, process: ${processTime.toFixed(2)}ms, imshow: ${imshowTime.toFixed(2)}ms, overhead: ${overhead.toFixed(2)}ms`;
          }
          let delay = 1000/FPS - overhead;
          setTimeout(processVideo, delay);
      } catch (err) {
          utils.printError(err);
      }
  };

  // schedule the first one.
  setTimeout(processVideo, 0);
}
