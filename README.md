# Custom-Image-Tags
Wordpress plugin to create Responsive slideshows with custom image tagging


note* Plugin requires having Custom Ready Meta installed on your wordpress site. *

Pre-requisite
Custom-Meta-Plugin: https://github.com/apatwary12/Custom-Ready-Meta
Jquery (2.2.4 or higher): https://code.jquery.com/



-----------------------------Blog Post ---------------------------------------------------

Summary:
Within my first two months of working at a smaller ad agency I was given a wordpress site to create a slider that had “Tagging” capabilities. The client was a mid-sized home developer that also included a Design center in which their buyers are able to select their proprietary line of home features for their home build. In order for this client to display their product line in a clear fashion without listing out products in a default e-commerce way, the client requested that the images in their slideshow be “tag-able” where the client’s buyer would be allowed to select a tag that was on the image and see the exact product that was in the slideshow.

Initial Thought Process & Issues: 
To begin we need to figure out coordinates over an image that will save the location of the image. Once the image coordinates have been saved we will create the images as relative div elements and the tag element will contain custom attributes that will contain the exact coordinates to specify their absolute location over the relative element.

The main concern here is as the background image is resized with the browser we will have the background plain change which will make the coordinate points of our tags invalid. To combat this i’ve allowed my front end js listen to and window resizes and recalculate the value in proportion to the original load and the new window size resulting and doing a 1:1 ratio change on the original coordinate values

Once we had the images I had to use a custom metafield builder to create multiple taggable image objects. Within these objects I would like to have the images be draggable and reordered to whatever the client required therefor using a json saving mechanism that isn’t bound to its original position ID but rather an order based saving mechanism that allows for wordpress to save it in a linear fashion.

Lastly i have included multiple category slideshows which allows the client to add tag-able slideshows of any category. 
