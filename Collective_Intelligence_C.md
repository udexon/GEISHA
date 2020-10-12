GEISHA introduces two novel features unavailable in conventional computing architecture:

- small (addressable and modifiable) functions and open access to the output of such functions.

In conventional computing architecture, a program is at least a few dozen lines up to millions of lines of code in length, and is usually not designed to share data with external entities at every stage of its execution.

We may draw parallels of GEISHA to what we know of human brain, made up of billions of neurons, which act as functional units, whose output are in turn openly available to any other neurons.

While existing systems that are commonly classified as "neural networks" exhibit "small node open access" with the program, the internal data are not available for open access in general.

## Incrementally Building an OpenCV Program, Collaboratively

Referring to the JavaScript OpenCV video snapshot example, we wish to illustrate how _cumulative and collaborative intelligence_ may arise when large number of users or programmers collaborate using GEISHA.

Due to the prevalence and dominance of the conventional computing architecture, few people would have thought of collaborating on a "simple" OpenCV program, comprising only rudimentary functions such as thresholding, smoothing, colour space transform etc.

We are only using this seemingly trivial example to illustrate how multiple programmers may collaborate using GEISHA, and then we wish to convince the readers of the usefulness of GEISHA when the number of programmers involved in collaboration scales towards 1 million and beyond.

To appreciate the benefits of incrementally building an OpenCV program by a group of programmers, let us look at Hu Ningxin's other OpenCV JS video-processing example (let's call this Program B) that consists of more functions:

<img src="https://github.com/udexon/GEISHA/blob/main/img/OCVJS_video.png" width=600>

- https://github.com/huningxin/opencv.js/blob/master/samples/video-processing/js/index.js
- https://github.com/huningxin/opencv.js/blob/master/samples/video-processing/index.html
- https://github.com/huningxin/opencv.js

Let's call the earlier example program A.

Now imagine how you would do the following:

- start with program A, incrementally make changes to create program B
- start with program B, deconstruct it into components and create program A

Without using novel principles such as GEISHA, you may not be able to derive anything interesting ideas from the two problems described above. 

With GEISHA however, imagine now instead of being ONE single program like program B, we now have several _function words_, each corresponding to a feature in program B, and the output of the function words are available for open access via a graph database mechanism to other function words.

In this example, the number of function words may just be around a dozen or so. 

What if we continue to expand the set of function words to include other robotic functions, from kinematics to various types of sensors. This may increase the number of function words to several thousands.

Some readers may ask, is this not simply changing the API of existing functions to reverse rolish notation / stack machine? What actual benefits can it bring besides being obviously a layer of syntactic sugar?

Indeed, transforming functions in existing programming languages into Phos function words would merely be a layer of syntactic sugar, if they are not integrated into the graph database, where live functions triggered by graph database events may match Phos words to conditional variables, besides composing new Phos words or decomposing existing Phos words into their component words. 




Define intelligence in terms of threats and opportunities, to benefits and survival of self.

Micro entity may have self awareness.

Macro entity may not, or may, against bigger environment. Earth vs. Internet.

The rules are like flowing water. Transfer of energy, high price to low price. Etc.

The Tao of Geisha. Bad name.

The Tao of PhosBrain ??

Human, Robot, Computers, System Intelligence.

