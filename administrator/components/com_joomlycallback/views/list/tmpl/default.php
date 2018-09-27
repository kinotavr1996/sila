<div class="container-fluid">
	<div class="row-fluid">
		<table id="CallbackTable" class="table "> 
			<thead> 
				<tr> 
					<?php if (count($this->list)>0){
							foreach ($this->list[0] as $key=>$caption){
								if (($key !== 'read') && (($key !== 'replied'))){?>
								<th><?php echo $key;?></th>
								<?php }
							}		
					}?>
					<th></th>	
					<th></th>
				</tr> 
			</thead>
			<tbody>
				<?php if (isset($this->list)){foreach($this->list as $feed){ ?>
					<tr>
						<?php foreach($feed as $key=>$v){
							if ($key !== 'read'){
								if ($key == 'replied'){?>
								<?php	} else {	
									if ($key == 'message'){
										$v = '<a href="index.php?option=com_joomlycallback&view=feedback&id='.$feed->id.'">'.substr($v, 0, 30).'</a>'; 
									}?>
									<td class="callback-td-long"><?php echo $v;?></td>
								<?php }	
							}	
						}?>
						<td class="callback-td"><i class="fa fa-trash-o delete_class" onclick="delete_feed(this);" id="<?php echo $feed->id;?>"></i></td>
					</tr>
				<?php }
				}?>
			</tbody>	
		</table>	
		<div>
			<ul class="pager">
				<li><a href="index.php?option=com_joomlycallback&page=<?php echo $this->PreviousPage;?>" class="previous"><?php echo JText::_('COM_JOOMLYCALLBACK_PREVIOUS');?></a></li>
				<li><a href="index.php?option=com_joomlycallback&page=<?php echo $this->NextPage;?>" class="next"><?php echo JText::_('COM_JOOMLYCALLBACK_NEXT');?></a></li>
			</ul>
		</div>	
	</div>
</div>
<script>
function delete_feed(feed)
{
	var con = confirm( "<?php echo JText::_('COM_JOOMLYCALLBACK_DELETE_FEED');?>" );
	if (con == true){
		del_id = feed.getAttribute("id");
		d = feed.parentNode.parentNode;
		d.parentNode.removeChild(d);
		
		var xhr = new XMLHttpRequest();
		
		var body = 'delete_id='+del_id;

		xhr.open("POST", 'index.php?option=com_joomlycallback&task=deletefeed', true)
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		xhr.send(body);
	}	
}
var current = <?php echo $this->CurrentPage;?>;
if (current==1){
	var b = document.getElementsByClassName("previous");
	b[0].className = b[0].className + " disabled";
	b[0].onclick = function(){
		return false;
	};
}	
var max = <?php echo $this->MaxPage;?>;
if (current>= max){
	var a = document.getElementsByClassName("next");
	a[0].className = a[0].className + " disabled";
	a[0].onclick = function(){
		return false;
	};
}	

</script>