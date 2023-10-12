<table class="table text-center table-bordered table-sm">
	<thead class="thead-dark">
		<tr>
			<th class="w-50">INFORMATION</th>
			<th>DATA</th>
		</tr>
	</thead>
	<tbody class="bg-light">
		<?php if (isset($prData['ptype']) && $prData['ptype'] !='') { ?>
			<tr>
				<td>Description</td>
				<td><?php 
				echo $prData['ptype']; 
				?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['prod_volt']) && $prData['prod_volt'] !='') { ?>
			<tr>
				<td>Voltage</td>
				<td><?php echo $prData['prod_volt']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['prod_out']) && $prData['prod_out'] !='') { ?>
			<tr>
				<td>Output</td>
				<td><?php echo $prData['prod_out']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['prod_regu'])  && $prData['prod_regu'] !='') { ?>
			<tr>
				<td>Regulator</td>
				<td><?php echo $prData['prod_regu']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['prod_pull_type']) && $prData['prod_pull_type'] !='') { ?>
			<tr>
				<td>Pulley Type</td>
				<td><?php echo $prData['prod_pull_type']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['prod_fan']) && $prData['prod_fan'] !='') { ?>
			<tr>
				<td>Fan</td>
				<td><?php echo $prData['prod_fan']; ?></td>
			</tr>
		<?php } ?>

		<?php if (isset($prData['prod_trans']) && $prData['prod_trans'] !='') { ?>
			<tr>
				<td>Transmission</td>
				<td><?php echo $prData['prod_trans']; ?></td>
			</tr>
		<?php } ?>
		<?php  if (isset($prData['prod_rot']) && $prData['prod_rot'] !='') { ?>
			<tr>
				<td>Rotation</td>
				<td><?php echo $prData['prod_rot']; ?></td>
			</tr>
		<?php } ?>

		<?php if (isset($prData['prod_dim']) && $prData['prod_dim'] !='') { ?>
			<tr>
				<td>Dimension</td>
				<td><?php echo $prData['prod_dim']; ?></td>
			</tr>
		<?php } ?>
		
		<?php if (isset($prData['position']) && $prData['position'] !='') { ?>
			<tr>
				<td>Position</td>
				<td><?php echo $prData['position']; ?></td>
			</tr>
		<?php } ?>
		
		<?php if (isset($prData['gr']) && $prData['gr'] !='') { ?>
			<tr>
				<td>GR</td>
				<td><?php echo $prData['gr']; ?></td>
			</tr>
		<?php } ?>
		
		<?php if (isset($prData['car_fits']) && $prData['car_fits'] !='') { ?>
			<tr>
				<td>Fits</td>
				<td><?php echo $prData['car_fits']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['prod_teeth']) && $prData['prod_teeth'] !='') { ?>
			<tr>
				<td>Teeth</td>
				<td><?php echo $prData['prod_teeth']; ?></td>
			</tr>
		<?php } ?>
		
		<?php if (isset($prData['fuel']) && $prData['fuel'] !='') { ?>
			<tr>
				<td>Fuel</td>
				<td><?php echo $prData['fuel']; ?></td>
			</tr>
		<?php } ?>
	
		<?php if (isset($prData['external_teeth']) && $prData['external_teeth'] !='') { ?>
			<tr>
				<td>External teeth</td>
				<td><?php echo $prData['external_teeth']; ?></td>
			</tr>
		<?php } ?>	

		<?php if (isset($prData['internal_teeth']) && $prData['internal_teeth'] !='') { ?>
			<tr>
				<td>Internal teeth</td>
				<td><?php echo $prData['internal_teeth']; ?></td>
			</tr>
		<?php } ?>		

		<?php if (isset($prData['diameter']) && $prData['diameter'] !='') { ?>
			<tr>
				<td>Diameter</td>
				<td><?php echo $prData['diameter']; ?></td>
			</tr>
		<?php } ?>		

		<?php if (isset($prData['height']) && $prData['height'] !='') { ?>
			<tr>
				<td>Height</td>
				<td><?php echo $prData['height']; ?></td>
			</tr>
		<?php } ?>				
		
		<?php if (isset($prData['abs_ring']) && $prData['abs_ring'] !='') { ?>
			<tr>
				<td>ABS Ring</td>
				<td><?php echo $prData['abs_ring']; ?></td>
			</tr>
		<?php }  ?>		
		
		<?php if (isset($prData['Weight']) && $prData['Weight'] !='') { ?>
			<tr>
				<td>Weight</td>
				<td><?php echo $prData['Weight']; ?></td>
			</tr>
		<?php } ?>

		<?php if (isset($prData['Disc_Dia']) && $prData['Disc_Dia'] !='') { ?>
			<tr>
				<td>Disc Diameter</td>
				<td><?php echo $prData['Disc_Dia']; ?></td>
			</tr>
		<?php } ?>	

		<?php if (isset($prData['Disc_Thick']) && $prData['Disc_Thick'] !='') { ?>
			<tr>
				<td>Disc Thickness</td>
				<td><?php echo $prData['Disc_Thick']; ?></td>
			</tr>
		<?php } ?>		

		<?php if (isset($prData['Piston_Dia']) && $prData['Piston_Dia'] !='') { ?>
			<tr>
				<td>Piston Diameter</td>
				<td><?php echo $prData['Piston_Dia']; ?></td>
			</tr>
		<?php } ?>		

		<?php if (isset($prData['Man']) && $prData['Man'] !='') { ?>
			<tr>
				<td>Man</td>
				<td><?php echo $prData['Man']; ?></td>
			</tr>
		<?php } ?>	

		<?php if (isset($prData['Pump_Type']) && $prData['Pump_Type'] !='') { ?>
			<tr>
				<td>Pump Type</td>
				<td><?php echo $prData['Pump_Type']; ?></td>
			</tr>
		<?php } ?>	

		<?php if (isset($prData['Pressure']) && $prData['Pressure'] !='') { ?>
			<tr>
				<td>Pressure</td>
				<td><?php echo $prData['Pressure']; ?></td>
			</tr>
		<?php } ?>			
	
		<?php if (isset($prData['Pully_Ribs']) && $prData['Pully_Ribs'] !='') { ?>
			<tr>
				<td>Pully Ribs</td>
				<td><?php echo $prData['Pully_Ribs']; ?></td>
			</tr>
		<?php } ?>	

		<?php if (isset($prData['Total_Length']) && $prData['Total_Length'] !='') { ?>
			<tr>
				<td>Total Length</td>
				<td><?php echo $prData['Total_Length']; ?></td>
			</tr>
		<?php } ?>	

		<?php if (isset($prData['Pin']) && $prData['Pin'] !='') { ?>
			<tr>
				<td>Pin</td>
				<td><?php echo $prData['Pin']; ?></td>
			</tr>
		<?php } ?>	

		<?php if (isset($prData['Fitting_position']) && $prData['Fitting_position'] !='') { ?>
			<tr>
				<td>Fitting Position</td>
				<td><?php echo $prData['Fitting_position']; ?></td>
			</tr>
		<?php } ?>	

		<?php if (isset($prData['No_of_Holes']) && $prData['No_of_Holes'] !='') { ?>
			<tr>
				<td>No of Holes</td>
				<td><?php echo $prData['No_of_Holes']; ?></td>
			</tr>
		<?php } ?>			
		
		<?php if (isset($prData['Bolt_Hole_Circle_Dia']) && $prData['Bolt_Hole_Circle_Dia'] !='') { ?>
			<tr>
				<td>Bolt Hole Circle Diameter</td>
				<td><?php echo $prData['Bolt_Hole_Circle_Dia']; ?></td>
			</tr>
		<?php } ?>	
		
		<?php if (isset($prData['Inner_Dia']) && $prData['Inner_Dia'] !='') { ?>
			<tr>
				<td>Inner Diameter</td>
				<td><?php echo $prData['Inner_Dia']; ?></td>
			</tr>
		<?php } ?>	
		
		<?php if (isset($prData['Outer_Dia']) && $prData['Outer_Dia'] !='') { ?>
			<tr>
				<td>Outer Diameter</td>
				<td><?php echo $prData['Outer_Dia']; ?></td>
			</tr>
		<?php } ?>	
		
				<?php if (isset($prData['Teeth_wheel_side']) && $prData['Teeth_wheel_side'] !='') { ?>
			<tr>
				<td>Teeth Wheel Side</td>
				<td><?php echo $prData['Teeth_wheel_side']; ?></td>
			</tr>
		<?php } ?>	
		

		<?php if (isset($prData['Teeth_Diff_Side'])  && $prData['Teeth_Diff_Side'] !='') { ?>
			<tr>
				<td>Teeth Diff. Side</td>
				<td><?php echo $prData['Teeth_Diff_Side']; ?></td>
			</tr>
		<?php } ?>
		

		<?php if (isset($prData['prod_add_inf'])  && $prData['prod_add_inf'] !='') { ?>
			<tr>
				<td>Add Info.</td>
				<td><?php echo $prData['prod_add_inf']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['Min_Th'])  && $prData['Min_Th'] !='') { ?>
			<tr>
				<td>Min Th</td>
				<td><?php echo $prData['Min_Th']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['Max_Th'])  && $prData['Max_Th'] !='') { ?>
			<tr>
				<td>Max Th</td>
				<td><?php echo $prData['Max_Th']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['Centre_Dia'])  && $prData['Centre_Dia'] !='') { ?>
			<tr>
				<td>Centre Dia.</td>
				<td><?php echo $prData['Centre_Dia']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['PCD'])  && $prData['PCD'] !='') { ?>
			<tr>
				<td>PCD</td>
				<td><?php echo $prData['PCD']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['Disc_Type'])  && $prData['Disc_Type'] !='') { ?>
			<tr>
				<td>Disc Type</td>
				<td><?php echo $prData['Disc_Type']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['Width'])  && $prData['Width'] !='') { ?>
			<tr>
				<td>Width</td>
				<td><?php echo $prData['Width']; ?></td>
			</tr>
		<?php } ?>
		<?php if (isset($prData['F_R'])  && $prData['F_R'] !='') { ?>
			<tr>
				<td>F/R</td>
				<td><?php echo $prData['F_R']; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>