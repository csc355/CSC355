<!DOCTYPE html>

<!--
     Name:         Tyler Maxwell
-->

<html>
   <head>
   
		<title>   testRegister.php       </title>
		<meta charset="utf-8">
		<link rel="stylesheet" type = "text/css" href = "Project.css"/>
	</head>
	<body>
		<center><img src = "../../ku.jpg"></center>
		<h1 style = "text-align:center"> Register </h1><br>
		<hr>

		<form align="center" action="Cred.php" method="POST">
			<table align="center">				
				<tbody>
					<tr>
						<td align="right">*First Name:</td>
						<td align="left"><input type="text" name="Fname" id="Fname"required/></td>
					</tr>
					<tr>
						<td align="right">*Last Name:</td>
						<td align="left"><input type="text" name="Lname" id="Lname"required/></td>
					</tr>
					<tr>
						<td align="right">*Email:</td>
						<td align="left"><input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required/></td>
					</tr>
					<tr>
						<td align="right">*Password:</td>
						<td align="left"><input type="password" name="pwd" id="pwd"required/></td>
					</tr>
					<tr>
						<td align="right">*Confirm Password:</td>
						<td align="left"><input type="password" name="Cpwd" id="Cpwd"required/></td>
					</tr>
					<tr>
						<td align="right">*Street1:</td>
						<td align="left"><input type="text" name="street1" id="street1"required/></td>
					</tr>
					<tr>
						<td align="right">Street2:</td>
						<td align="left"><input type="text" name="street2" id="street2"></td>
					</tr>
					<tr>
						<td align="right">*City:</td>
						<td align="left"><input type="text" name="city" id="city"required/></td>
					</tr>
					<tr>
						<td align="right">*State:</td>
						<td align="left"><select name = "state">
											
											<option value="AL">Alabama</option>
											<option value="AK">Alaska</option>
											<option value="AZ">Arizona</option>
											<option value="AR">Arkansas</option>
											<option value="CA">California</option>
											<option value="CO">Colorado</option>
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="DC">District Of Columbia</option>
											<option value="FL">Florida</option>
											<option value="GA">Georgia</option>
											<option value="HI">Hawaii</option>
											<option value="ID">Idaho</option>
											<option value="IL">Illinois</option>
											<option value="IN">Indiana</option>
											<option value="IA">Iowa</option>
											<option value="KS">Kansas</option>
											<option value="KY">Kentucky</option>
											<option value="LA">Louisiana</option>
											<option value="ME">Maine</option>
											<option value="MD">Maryland</option>
											<option value="MA">Massachusetts</option>
											<option value="MI">Michigan</option>
											<option value="MN">Minnesota</option>
											<option value="MS">Mississippi</option>
											<option value="MO">Missouri</option>
											<option value="MT">Montana</option>
											<option value="NE">Nebraska</option>
											<option value="NV">Nevada</option>
											<option value="NH">New Hampshire</option>
											<option value="NJ">New Jersey</option>
											<option value="NM">New Mexico</option>
											<option value="NY">New York</option>
											<option value="NC">North Carolina</option>
											<option value="ND">North Dakota</option>
											<option value="OH">Ohio</option>
											<option value="OK">Oklahoma</option>
											<option value="OR">Oregon</option>
											<option value="PA">Pennsylvania</option>
											<option value="RI">Rhode Island</option>
											<option value="SC">South Carolina</option>
											<option value="SD">South Dakota</option>
											<option value="TN">Tennessee</option>
											<option value="TX">Texas</option>
											<option value="UT">Utah</option>
											<option value="VT">Vermont</option>
											<option value="VA">Virginia</option>
											<option value="WA">Washington</option>
											<option value="WV">West Virginia</option>
											<option value="WI">Wisconsin</option>
											<option value="WY">Wyoming</option>
										</select>
					</tr>
					<tr>
						<td align="right">*Zip:</td>
						<td align="left"><input type="text" pattern="[0-9]{5}" name="zip" id="zip"required/></td>
					</tr>
				
					<tr>
						<td align="right"><button type="submit" value="Submit">Submit</button></td>
						<td align="left"><button type="reset" value="Reset">Reset</button></td>
					</tr>
				</tbody>	
			</table>		
	
		</form>
		
		
		</body>
</html>
