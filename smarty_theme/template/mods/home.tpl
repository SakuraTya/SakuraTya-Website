<div id="popular_works_show">
	<div id="popworks_group_header" class="group_header_bg">
		<div id="popworks_group_label"></div>
		<div id="search_box_for_pop">
			<div class="search_box_wrapper">
				<span class="search_box_icon"></span>
				<input class="search_box_input" name="search" id="search_pop" placeholder="搜索..." type="text" />
			</div>
		</div>
		<div id="tags_selector_for_pop">
			<ul>
				{foreach $tags as $tag}
				<li data="{$tag->term_id}">{$tag->name}</li>
				{/foreach}
				<div style="clear:both;display:block;"></div>
			</ul>
		</div>
	</div>
</div>