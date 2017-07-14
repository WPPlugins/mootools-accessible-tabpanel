document.addEvent('domready', function(){

	var tabPane = new TabPane('demo_small');

   
	$('demo_small').addEvent('click:relay(.remove)', function(e) {
		new Event(e).stop();
		var parent = e.target.getParent('.tab');
		tabPane.closeTab(parent);
	});
    

});
