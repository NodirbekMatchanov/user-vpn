
window.onLoad = (f) => {
	document.addEventListener('DOMContentLoaded', () => f())
}

document.html = document.documentElement


$.fn.foreach = function(f) {
	this.each(function() {
		f(this)
	})
}



$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};


window.serialize = (form) => {
	var data = $(form).serializeObject()
	return data
}


window.scrollToEl = (el) => {
	var $el = $(el)
	var offset = 100
	var top = $el.offset().top - offset

	$('html, body').animate({
		scrollTop: top
	}, 1000)
}


window.scrollToHash = (hash = false) =>  {
	if (!hash) {
		hash = window.location.hash
		hash = hash.replace('#/#', '#')
	}
	if (hash && !~hash.indexOf('#/')) {
		var el = document.querySelector("[name='"+ hash.replace('#', '') +"']") || document.querySelector(hash);

		if (el) {
			setTimeout(() => {
				scrollToEl.bind(null, el)
			}, config.animation.transition)
		}
	}
}

window.clearHover = () => {
	document.body.classList.add('disable-hover')
	setTimeout(() => {
		document.body.classList.remove('disable-hover')
	}, 20)
}

window.debounce = function(f, ms) {
	let isCooldown = false;

	return function() {
		if (isCooldown) return;

		f.apply(this, arguments);

		isCooldown = true;

		setTimeout(() => isCooldown = false, ms);
	};
}



window.getScrollbarWidth = () => {
	const outer = document.createElement('div');
	outer.style.visibility = 'hidden';
  outer.style.overflow = 'scroll'; // forcing scrollbar to appear
  outer.style.msOverflowStyle = 'scrollbar'; // needed for WinJS apps
  document.body.appendChild(outer);

  const inner = document.createElement('div');
  outer.appendChild(inner);

  const scrollbarWidth = (outer.offsetWidth - inner.offsetWidth);

  outer.parentNode.removeChild(outer);

  return scrollbarWidth;
}

window.key = () => {
	return Math.random()
}

window.dd = (msg) => {
	console.log(msg)
}