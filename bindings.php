<?php
header('content-type:application/xml');
header('expires: ' . str_replace('+0000', 'GMT', gmdate('r', time() + 3600*24))); //one day later
echo '<?'.'xml version="1.0"?'.'>';?>
<bindings xmlns="http://www.mozilla.org/xbl" xmlns:html="http://www.w3.org/1999/xhtml">
<?php for($i = 0; $i < @$_GET['count']; $i++): ?>
	<binding id="rule<?php echo $i+1; ?>">
		<implementation>
			<constructor>
			<![CDATA[
try {
				var i = <?php echo $i ?>;
				
				var el = this;
				var $el = jQuery(el);
				xblConsole.info(cssTransitionRules[i].selectorText)
				//xblConsole.info(cssTransitionRules[i].transitionProperty)
				
				//Make sure that the transition property and duration are stored for this element, because it
				//  may have been dynamically generated
				if(cssTransitionRules[i].transitionProperty.length)
					$el.data('transitionProperty', cssTransitionRules[i].transitionProperty);
				if(cssTransitionRules[i].transitionDuration)
					$el.data('transitionDuration', cssTransitionRules[i].transitionDuration);
				
				//For each of the transition properties, set the style to the current property so that subsequent rules don't override immediately
				var transitionProperties = $el.data('transitionProperty');
				var transitionStyle = {};
				//var currentStyle = {};
				//var previousStyle = $el.data('transitionPreviousStyle') || {};
				//xblConsole.info(cssTransitionRules[i]);
				jQuery(transitionProperties).each(function(){
					//currentStyle[this] = $el.css(this);
					if(!el.style[this]){
						//$el.css(this, currentStyle[this]);
						$el.css(this, $el.css(this));
					}
					if(cssTransitionRules[i].style[this]){
						//xblConsole.info(this, currentStyle[this])
						transitionStyle[this] = cssTransitionRules[i].style[this];
					}
					//else if(previousStyle[this]){
					//	transitionStyle[this] = previousStyle[this];
					//}
					
					//xblConsole.warn(cssTransitionRules[i].style)
					
				});
				//xblConsole.info(transitionStyle)
				//xblConsole.warn(transitionProperties)
				
				$el.stop().animate(transitionStyle, $el.data('transitionDuration'));
				
				//for(var name in currentStyle){
				//	previousStyle[name] = currentStyle[name];
				//}
				//$el.data('transitionPreviousStyle', previousStyle);
				
				
				//#### We really need to find out when a binding is REMOVED
				//document.defaultView.getComputedStyle($('#foo')[0], null).MozBinding
				//We does this only return 1? It should return a list of bindings that are applied!
				//We need to get all of the bindings that are applied in the cascade
				
				//xblConsole.info(cssTransitionRules[i].selectorText)
				
				//xblConsole.info(cssTransitionRules[i].selectorText)
				//console.info($el.data('transitionProperty'));
				//console.info($el.data('transitionDuration'));
				
				
				//Note: This doesn't work with :not(:target)
				//var selectorWithoutPseudoClasses = cssTransitionRules[i].selectorText.replace();
				
				//if(cssTransitionRules[i].selectorText.indexOf(':target') == -1){
				//	var selectorWithoutTarget = cssTransitionRules[i].selectorText.replace(/:target/, '');
				//}
				
				
				//var selector = "<?php echo urldecode(stripslashes(@$_GET['selector'])) ?>";
				if(xblConsole){
					//xblConsole.info(cssTransitionRules[i].selectorText);
					//xblConsole.info(cssTransitionRules[i].transitionProperty);
				}
}catch(e){
	xblConsole.error(e)
}
			]]>
			</constructor>
			<!--
			We cannot use the destructor to determine when a rule is removed. See Bug 83635 -  XBL binding not deleted on removal from document tree  https://bugzilla.mozilla.org/show_bug.cgi?id=83635
			This sucks.
			-->
			<!--<destructor>
			<![CDATA[
				if(xblConsole)
					xblConsole.info('destruct');
				var $el = jQuery(this);
				$el.removeData('transitionProperty');
				$el.removeData('transitionDuration')
			]]>
			</destructor>-->
		</implementation>
	</binding>
<?php endfor; ?>
</bindings>