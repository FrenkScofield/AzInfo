function notify(msg,typ){
	if(typ==undefined) typ='message';
	$('#StatusBar').jnotifyAddMessage({
		text: '<div align=center >'+msg+'</div>',
		permanent: false,
		type: typ
	});
	if(typ=='error'){
		alert(msg);
	}
}

// <TABS>
function closeTab(t){
    var index = $(t).parents('li').index();
    $tabs.tabs('remove',index);
}
function getSelectedTab(){    
    return $tabs.tabs('option', 'selected');
}
function closeCurrentTab(){
	var i = getSelectedTab();
	if(i>=0){
		$tabs.tabs('remove',i);
	}
}
function reloadCurrentTab(){    
    var i = getSelectedTab();
    if(i>=0){
		$tabs.tabs("load",i);
	}
}
// </TABS>
