<?$this->inside("layout",array())?>
<?
/**
 * generate the file before template display (beacause the inside layout) 
 */
Less::getIncludeTag("assets/styles")
?>
<h3 class="fs1">Geocode details</h3>
<pre class="prettyprint lang-css linenums">
<?=  htmlentities(file_get_contents("media/less-css/assets/styles.css"))?>
</pre>
<pre class="">
<?=  file_get_contents("media/less-css/assets/styles.css")?>
</pre>