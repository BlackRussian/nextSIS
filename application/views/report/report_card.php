<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
        header("Content-disposition: attachment; filename=\"report_card.xlsx\"");
        ?>
		<table cellpadding="5" style="font-size:10pt">
			<tr>
				<td>Name: </td>
				<td>DOB: </td>
				<td>Number in Class: </td>
			</tr>
			<tr>
				<td>Grade: </td>
				<td>Age: </td>
				<td>Gender: </td>
			</tr>
			<tr>
				<td>New Student: </td>
				<td>Average Class Age: </td>
				<td>Time Late: </td>
			</tr>
			<tr>
				<td>House: </td>
				<td>Sessions Absent: </td>
				<td>Position in Class: </td>
			</tr>
			<tr>
				<td>Promoted to: </td>
				<td>Possible Sessions: </td>
				<td>Detention/Order Marks: </td>
			</tr>
		</table>
		<table cellpadding="5" style="font-size:10pt">
			<tr>
				<td>Courses</td>
				<td>Term Mark</td>
				<td>End-Year Mark</td>
				<td>Final Mark</td>
				<td>Position In Exam</td>
				<td>Conduct In Class</td>
				<td>Teachers Comments</td>
				<td>Teacher</td>
			</tr>
			<tr>
				<td>English Language</td>
				<td>28%</td>
				<td>89%</td>
				<td>100%</td>
				<td>1</td>
				<td>G</td>
				<td>8</td>
				<td>Omarie Case</td>
			</tr>
			<tr>
				<td>English Language</td>
				<td>28%</td>
				<td>89%</td>
				<td>100%</td>
				<td>1</td>
				<td>G</td>
				<td>8</td>
				<td>Omarie Case</td>
			</tr>
			<tr>
				<td>English Language</td>
				<td>28%</td>
				<td>89%</td>
				<td>100%</td>
				<td>1</td>
				<td>G</td>
				<td>8</td>
				<td>Omarie Case</td>
			</tr>
			<tr>
				<td>English Language</td>
				<td>28%</td>
				<td>89%</td>
				<td>100%</td>
				<td>1</td>
				<td>G</td>
				<td>8</td>
				<td>Omarie Case</td>
			</tr>
			<tr>
				<td><b>Average Grade</b></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><b>100%</b></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="7">NB: Students' Term  Grades  and Mid-Term Exam Grades are calculated out of 40% and  60% respectively.</td>
			</tr>
		</table>
		<table cellpadding="5" style="font-size:10pt">
			<tr>
				<td colspan="2"><b>Student Profile (Form Teacher)</b></td>
			</tr>
			<tr>
				<td>Speech</td>
				<td>S</td>
			</tr>
			<tr>
				<td>Deportment</td>
				<td>S</td>
			</tr>
			<tr>
				<td>Cheeful</td>
				<td>S</td>
			</tr>
		</table>
		<table cellpadding="5">
			<tr>
				<td colspan="2"><b>Comments</b></td>
			</tr>
			<tr>
				<td> Comments from Omarie Case</td><td> here are some comments</td>
			</tr>
			<tr>
				<td> Comments from Christopher Hinds</td><td> here are some comments</td>
			</tr>
		</table>
		<table cellpadding="5">
			<tr>
				<td><b>Student Profile &amp; Conduct Key</b></td>
			</tr>
			<tr>
				<td colspan="7">E = Excellent, G = Good, S = Satisfactory, D = Disruptive, U = Unsatisfactory, P = Poor, Na = Not Applicable, Ch = Cheated, Ns = No Submission</td>
			</tr>
			<tr>
				<td><b>Grade Key</b></td>
			</tr>
			<tr>
				<td colspan="7">A = 80-100, A- = 75-79, B+= 70-74, B=  65-69, B-=  60-64, C+ = 55-59, C =  50-54, C- = 45-49, D+ = 40-44D = 35-39, D- = 21-34, E = 0-20</td>
			</tr>
		</table>

	</body>
</html>