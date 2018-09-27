function call_callback(){
	var callback_ids = callback_ids || [];
	callback_ids.push(callback_module_id);
	var callback_sending_flag = callback_sending_flag || [];
	if (callback_sending_flag[callback_module_id] == undefined)
	{
		callback_sending_flag[callback_module_id] = getCallbackSendingFlag(callback_module_id);
	}
	function getCallbackCookie(name) {
	  var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	  ));
	  return matches ? decodeURIComponent(matches[1]) : undefined;
	}
	function getCallbackSendingFlag(m_id){
		var sendingalert = getCallbackCookie("callback-sending-alert"),
			alerttype = getCallbackCookie("callback-alert-type"),
			sflag = 0;
		if ((typeof sendingalert !== 'undefined') && (sendingalert == m_id))
		{
			al = document.getElementById("special-alert" + m_id);
			if (alerttype == 'success')
			{
				sflag = 1;
			} else if (alerttype == 'captcha')
			{
				sflag = 2;
				al.childNodes[1].style.backgroundColor = "red";
				al.childNodes[3].childNodes[1].innerHTML = captcha_error;
			}
			document.cookie = 'callback-sending-alert=333; Path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
			document.cookie = 'callback-alert-type=;Path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
		} else 
		{
			sflag = 0;
		}	
		return sflag;
	}
	window.addEventListener('load', function() {callback_recaptcha(); joomly_callback(callback_ids); } , false); 
	function joomly_callback(m){	
		m.forEach(function(mod_id, i, arr) {			
			var opener = Array.prototype.slice.call((document.getElementsByClassName("joomly-callback")));
			var slider = document.getElementById('button-joomly-callback-form' + mod_id);
			for (var i=0; i < opener.length; i++) {

				opener[i].onclick = function(){
					
					var lightbox = document.getElementById("joomly-callback"),
						dimmer = document.createElement("div"),
						close = document.getElementById("joomly-callback-close" + mod_id);
					
					dimmer.className = 'dimmer';
					
						dimmer.onclick = function(){
							if (slider)
							{
								slider.classList.toggle('closed');	
							}
							dimmer.parentNode.removeChild(dimmer);			
							lightbox.style.display= 'none';
						}
						
						close.onclick = function(){
							if (slider)
							{
								slider.classList.toggle('closed');	
							}	
							dimmer.parentNode.removeChild(dimmer);			
							lightbox.style.display= 'none';
						}
					
					if (slider)
					{
						slider.classList.toggle('closed');	
					}
								
						
					document.body.appendChild(dimmer);
					var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
					lightbox.style.display= 'block';
					if (window.innerHeight > lightbox.offsetHeight )
					{
						lightbox.style.top = scrollTop + (window.innerHeight- lightbox.offsetHeight)/2 + 'px';
					} else
					{
						lightbox.style.top = scrollTop + 10 + 'px';
					}
					if (window.innerWidth>400){
						lightbox.style.width = '400px';
						lightbox.style.left = (window.innerWidth - lightbox.offsetWidth)/2 + 'px';
					} else {
						lightbox.style.width = (window.innerWidth - 70) + 'px';
						lightbox.style.left = (window.innerWidth - lightbox.offsetWidth)/2 + 'px';
					}	
					
					return false;
				}
			}	

			var box_time_today=document.getElementById("time-today" + mod_id);
			if (box_time_today !== null)
			{
				var box_day=document.getElementById("day" + mod_id);
				var box_time_any=document.getElementById("time-any" + mod_id);
				var cur_time=document.getElementById("cur-time" + mod_id);
				box_day.onchange=function (){
					if (box_day.selectedIndex == 0){
						box_time_today.style.display = "inline-block";
						box_time_any.style.display = "none";
						cur_time.value = 0;
					} else{

						box_time_today.style.display = "none";
						box_time_any.style.display = "inline-block";
						cur_time.value = 1;
						console.log(cur_time.value);
					}	
				}
			}
			
			if (callback_sending_flag[mod_id] >= 1){
				var lightbox = document.getElementById("special-alert" + mod_id),
				dimmer = document.createElement("div"),
				close = document.getElementById("callback-alert-close" + mod_id);
				
					dimmer.className = 'dimmer';
				
				dimmer.onclick = function(){
					dimmer.parentNode.removeChild(dimmer);			
					lightbox.style.display= 'none';
				}
				
				close.onclick = function(){
					dimmer.parentNode.removeChild(dimmer);			
					lightbox.style.display= 'none';
				}
					
				document.body.appendChild(dimmer);
				document.body.appendChild(lightbox);
				var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
				lightbox.style.display= 'block';
				if (window.innerHeight > lightbox.offsetHeight )
				{
					lightbox.style.top = scrollTop + (window.innerHeight- lightbox.offsetHeight)/2 + 'px';
				} else
				{
					lightbox.style.top = scrollTop + 10 + 'px';
				}
				if (window.innerWidth>400){
					lightbox.style.width = '400px';
					lightbox.style.left = (window.innerWidth - lightbox.offsetWidth)/2 + 'px';
				} else {
					lightbox.style.width = (window.innerWidth - 70) + 'px';
					lightbox.style.left = (window.innerWidth - lightbox.offsetWidth)/2 + 'px';
				}	
				
				setTimeout(callback_remove_alert, 3000);
				
				function callback_remove_alert()
				{

					if (lightbox.style.display  != "none")
					{
						dimmer.parentNode.removeChild(dimmer);			
						lightbox.style.display = 'none';
					}
				}
			}	
			callback_sending_flag[mod_id] = 0;	
		});	
		callback_ids = [];
	}
}
function callback_validate(element)
{
	var inputs = element.getElementsByClassName("joomly-callback-field"),
		errorMessages = element.getElementsByClassName("callback-error-message");
	for ( var i = errorMessages.length; i > 0; i-- ) {
			errorMessages[ i - 1].parentNode.removeChild( errorMessages[ i - 1] );
			console.log(i);
		}
	
	for (var i = 0; i < inputs.length; i++) {
		if ((inputs[i].hasAttribute("required")) &&(inputs[i].value.length == 0)) { 
			event.preventDefault();	
			parent = inputs[i].parentNode;
			parent.insertAdjacentHTML( "beforeend", "<div class='callback-error-message'>" + 
			   type_field +
				"</div>" );
				console.log("ad" + i)
		}
	}	
}
function joomly_callback_analytics(mod_id){
if (callback_params[mod_id].yandex_metrika_id)
{
	if (typeof Ya.Metrika !== undefined){
		var yaCounter= new Ya.Metrika(callback_params[mod_id].yandex_metrika_id);
		yaCounter.reachGoal(callback_params[mod_id].yandex_metrika_goal);
	} else if (typeof Ya.Metrika2 !== undefined){
		var yaCounter= new Ya.Metrika2(callback_params[mod_id].yandex_metrika_id);
		yaCounter.reachGoal(callback_params[mod_id].yandex_metrika_goal);
	}
}
if (callback_params[mod_id].google_analytics_category)
{
	ga('send', 'event', callback_params[mod_id].google_analytics_category, callback_params[mod_id].google_analytics_action, callback_params[mod_id].google_analytics_label, callback_params[mod_id].google_analytics_value);
}
}
function callback_recaptcha(){
	var captchas = document.getElementsByClassName("g-callback-recaptcha");
	for (var i=0; i < captchas.length; i++) {
		var sitekey = captchas[i].getAttribute("data-sitekey");
		if ((captchas[i].innerHTML === "") && (sitekey.length !== 0))
		{
			grecaptcha.render(captchas[i], {
	          'sitekey' : sitekey,
	          'theme' : 'light'
	        });		
		}
	};
}
