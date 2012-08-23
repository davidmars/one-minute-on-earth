<h3 class="fs1">Video details</h3>
<pre class="prettyprint lang-xml linenums">
    <?=  htmlentities($video->feedContent)?>
</pre>

<h3 class="fs1">Geocode details</h3>
<pre class="prettyprint lang-json linenums">
    <?=  htmlentities($video->geoPlace->feedContent)?>
</pre>