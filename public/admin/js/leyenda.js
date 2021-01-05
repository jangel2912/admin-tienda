$('.leyenda .icon-leyenda').hover(function() {
	let _parent = $(this).parents('.leyenda');
	let _child = _parent.children('.info-leyenda');
	_child.css('display', 'inline-block');

}, function() {
	let _parent = $(this).parents('.leyenda');
	let _child = _parent.children('.info-leyenda');
	_child.css('display', 'none');
});