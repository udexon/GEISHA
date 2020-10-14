## Roadmap towards Technological Singularity
- Measured in the number of Phos WORDS (Homoiconic Graph Functions, HGF) in PhosGraph decentralized graph database (DCGDB)

<!-- Use this catch phrase to make it easy for readers understand -->

The concept of "technological singularity" dates at least two decades before being coined by Vernor Vinge in 1993, whose popularity was no doubted aided by the then nascent public access Internet and the microcomputer revolution, together with media portrayal of robotic apocalypse, from Terminator to the Matrix.

Despite the attention it receives, no one seems to be able to provide a concise roadmap, with objective metrics towards the realization of technological singularity (TechSing).

(We are inclined to use TechSing as the abbreviation as TS is now a common abbreviation for TypeScript, a programming language, as well as being easier to pronounce.)

So here is the essence of the answer of this article:

- Question: What are the objective metrics to measure our progress towards technological singularity?

- Answer: The number of Phos WORDS (homoiconic graph functions HGF) in PhosGraph decentralized graph database (DCGDB).

- Timeline
1. Phosifying all existing AI projects
2. Make Phos AI projects easy to code by beginners. Check number of beginners.
3. Automate GEISHA. Check output of GEISHA vs. human programmers.
4. TechSing = time when GEISHA automated outputs > human



As we have outlined in GEISHA README ....

Function to map graph search key to Phos words are themselves Phos words. Add this paragraph here.

https://en.m.wikipedia.org/wiki/Technological_singularity



All programs has memory and file output isolated from others, antithesis of graph database. Hence there is no avenue or possibility of cumulative intelligence. Intelligence has to be cumulative, accumulated from numerous minute operations. Only Phos words and graph database can facilitate this.


Intelligence may arise as large number of users on internet use Phos to process data and share as graph database.

Image to vocabulary annotation (derive key) can be manual. Then key may trigger other process.

Collective Intelligence 集思广益


## B. Demonstration with JavaScript OpenCV 

In this tutorial, we will show you how to convert a conventional JavaScript OpenCV video processing web page into a PhosCV _WORD_ (homoiconic graph function, HGF) + PhosGraph graph database module, to demonstrate the Collective Intelligence model that we described above.

What we did essentially was to take a snapshot from a video stream of a camera device, and save the image as a based64 encoded string in a JSON file on the server, which forms part of PhosGraph graph databse (GDB).

1) At first, we forked the code from Hu Ningxin's "video pipeline test" project from Codepen:

- https://codepen.io/huningxin/pen/ReMezx

2) After making some minor changes (see ... for details), notably removing the grey scale conversion, so that the output image is just a snap shot of the video stream when "Stop" is pressed.

The modified code is available for download at:
- https://github.com/udexon/GEISHA/tree/main/PhosCV

- Figure 1: Video stream is incoming from camera device.
<img src="https://github.com/udexon/GEISHA/blob/main/img/PhosCV_Start.png" width=600>

- Figure 2: "Stop" has been pressed. Image in `canvasOutput` is frozen.
<img src="https://github.com/udexon/GEISHA/blob/main/img/PhosCV_Snap.png" width=600>

3) The image data from `canvasOutput` is stored into `var photo` after being converted using `.toDataURL()`.

`U()` is a PhosGraph function to send JSON from the browser front end to the back end server.

```js
var photo = canvasOutput.toDataURL('image/jpeg');   
U({photo: photo}) // send JSON
```

<img src="https://github.com/udexon/GEISHA/blob/main/img/log_files.png" width=600>

<img src="https://github.com/udexon/GEISHA/blob/main/img/image_json.png" width=600>


## C. [Small Nodes and Many Connections](https://github.com/udexon/GEISHA/blob/main/Collective_Intelligence_C.md)


## D. PhosCV / PhosGraph Details

<img src="https://github.com/udexon/GEISHA/blob/main/img/PhosCV_ajax_auth.png" width=400>

<img src="https://github.com/udexon/GEISHA/blob/main/img/PhosCV_nick.png" width=400>

https://stackoverflow.com/questions/13198131/how-to-save-an-html5-canvas-as-an-image-on-a-server

var photo = canvasOutput.toDataURL('image/jpeg');   

The rest is PhosAjax.
