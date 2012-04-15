<?php

// vars
global $post;
		
// get location data
$location = $this->get_acf_location($post->ID);

if(empty($location['rules']))
{
	$location['rules'] = array(
		array(
			'param'		=>	'post_type',
			'operator'	=>	'',
			'value'		=>	'',
		)
	);
}

?>
<table class="acf_input widefat" id="acf_location">
	<tbody>
	<tr>
		<td class="label">
			<label for="post_type"><?php _e("Rules",'acf'); ?></label>
			<p class="description"><?php _e("Create a set of rules to determine which edit screens will use these advanced custom fields",'acf'); ?></p>
		</td>
		<td>
			<div class="location_rules">
				<table class="acf_input widefat" id="location_rules">
					<tbody>
						<?php foreach($location['rules'] as $k => $rule): ?>
						<tr>
						<td class="param"><?php 
						
							$args = array(
								'type'	=>	'select',
								'name'	=>	'location[rules]['.$k.'][param]',
								'value'	=>	$rule['param'],
								'choices' => array(
									'post_type'		=>	'Post Type',
									'page'			=>	'Page',
									'page_type'		=>	'Page Type',
									'page_parent'	=>	'Page Parent',
									'page_template'	=>	'Page Template',
									'post'			=>	'Post',
									'post_category'	=>	'Post Category',
									'post_format'	=>	'Post Format',
									'user_type'		=>	'User Type',
									'taxonomy'		=>	'Taxonomy'
								)
							);
							
							// validate
							if($this->is_field_unlocked('options_page'))
							{
								$args['choices']['options_page'] = "Options Page";
							}
							
							$this->create_field($args);							
							
						?></td>
						<td class="operator"><?php 	
							
							$this->create_field(array(
								'type'	=>	'select',
								'name'	=>	'location[rules]['.$k.'][operator]',
								'value'	=>	$rule['operator'],
								'choices' => array(
									'=='	=>	'is equal to',
									'!='	=>	'is not equal to',
								)
							)); 	
							
						?></td>
						<td class="value"><?php 
							
							$this->ajax_acf_location(array(
								'key' => $k,
								'value' => $rule['value'],
								'param' => $rule['param'],
							)); 
							
						?></td>
						<td class="buttons">
							<a href="javascript:;" class="remove"></a>
							<a href="javascript:;" class="add"></a>
						</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					
				</table>
				<p><?php _e("match",'acf'); ?> <?php $this->create_field(array(
									'type'	=>	'select',
									'name'	=>	'location[allorany]',
									'value'	=>	$location['allorany'],
									'choices' => array(
										'all'	=>	'all',
										'any'	=>	'any',							
									),
								)); ?> <?php _e("of the above",'acf'); ?></p>
			</div>
			
			
		</td>
		
	</tr>

	</tbody>
</table>