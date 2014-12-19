<?php
/*
Template Name: Doctor Enrollment
*/
?>
<style>
	.entry-content	{
		margin-top: 15px !important;
	}
	.header_image	{
		max-height: 550px !important;
		height: 550px;
		position: relative !important;
	}
	.row_container	{
		width: 100% !important;
		background: url('<?php echo get_template_directory_uri(); ?>/css/images/cream_pixels.png');	
		margin-top: 550px;
	}
	@media only screen and (min-width: 40.063em)	{
		.top-bar-section .has-dropdown.hover>.dropdown, .top-bar-section .has-dropdown.not-click:hover>.dropdown	{
			padding-top: 11px !important;
		}
	}
	.header_image_title {
		display: inline-block;
		top: 0;
		margin-top: 185px !important;
		position: absolute;
		width: 100%;
		left: 0;
		color: #fff  !important;
		text-shadow: 2px 2px 2px rgba(0,0,0,0.8);
		font-family: 'adellethin';
	}	
	.entry-content	{
		margin-bottom: 0px !important;
	}	
</style>
<?php get_header(); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<div class="doctor-enrollment-page">
<?php if ( has_post_thumbnail() ) { ?>
<div class="header_image">
	<div id="featured"><?php the_post_thumbnail(); ?></div>
</div>
<div class="header_image_title"><h1><?php echo get_the_title(); ?></h1></div>

<?php } ?>

<div class="row_container" id="row_container">
	<div class="row">
		<div class="small-12 columns" role="main">

		<?php do_action('foundationPress_before_content'); ?>
		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<?php do_action('foundationPress_page_before_entry_content'); ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
				<div class="enroll_container">
				
                <div class="enroll doctor-enrollment" id="form_one">
                
                	<form>
                
                	<div class="practice-information">
                    
                    	<div class="step1">
                
						<h1>Step 1: Practice Information</h1>
                    
                    	<table class="left">
                    	
                        	<tr>
                        		<td colspan="3">Name<input type="text" value="Practice Name" id="practice_name" name="practice_name"></td>
                        	</tr>
                        
                        	<tr>
                        		<td colspan="3">Address<input type="text" value="Address"  name="practice_address"></td>
                        	</tr>
                        
                        	<tr>
                        		<td colspan="3">Address 2<input type="text" value="Address 2" name="practice_address2"></td>
                        	</tr>
                        
                        	<tr>
                        		<td>City<input type="text" value="City" id="practice_city" name="practice_city"></td>
                            	<td>State <?php echo form_dropdown('practice_state', get_states(), 'UT'); ?></td>
                            	<td>Zip<input value="zip" type="text" id="practice_zip" name="practice_zip"></td>
                        	</tr>   
                        
                        	<tr>
                        		<td colspan="3">Number of doctors<select name="practice_doctors"><?php for($i=0; $i<=1000; $i++) {?><option value="<?php echo $i; ?>"><?php echo $i; ?></option> <?php } ?></select></td>
                        	</tr>                       
                    
                    	</table>
                    
                    	<table class="right">
                    
                    		<tr>
                        		<td>Primary Phone<input type="text" id="practice_phone" value="primary phone" name="practice_phone"></td>
                        	</tr>
                    
                        	<tr>
                        		<td>Primary Email<input type="text" id="practice_email" value="primary email" name="practice_email"></td>
                        	</tr>
                        
                        	<tr>
                        		<td>Routing Number<input type="text" value="Routing Number" name="practice_routing_number"></td>
                        	</tr>  
                        
                        	<tr>
                        		<td>Bank Account<input type="text" value="Bank Account" name="practice_bank_account"></td>
                        	</tr>   
                                                          
                    	</table>
                    
                   		</div>
                        
                        <div class="step2">
					
                    	<h1>Step 2: Doctor Information</h1>
                    
                   	 	<table>
                    		<tr>
                        		<td>First Name<input type="text" value="First Name" id="firstname" name="firstname"></td>
                            	<td>Last Name<input type="text" value="Last Name" id="lastname" name="lastname"></td>
                            	<td>Mobile Number<input type="text" value="Mobile" id="cellphone" name="cellphone"></td>
                        	</tr>
                        
                        	<tr>
                    			<td colspan="3">
									<input type="checkbox" class="css-checkbox" id="alerts" checked="checked">
									<label for="alerts" class="css-label">Recieve message alerts from Renew My Healthcare (requires mobile phone number)</label>
								</td>
                    		</tr>
                        
                        	<tr>
                        		<td colspan="3">Email<input type="text" value="doctor2@renew.com" id="email" name="email"></td>
                           
                        	</tr>
                        
                        	<tr>
                        		<td>Undergrad School<input type="text" value="School" id="undergrad_school" name="undergrad_school"></td>
                            	<td>Degree Earned<input type="text" value="School"  id="undergrad_degree" name="undergrad_degree"></td>
                            	<td>Graduation Date<input class="date" value="School" type="text" id="undergrad_date" name="undergrad_date"></td>
                        	</tr>
                        
                        	<tr>
                        		<td>Medical School<input type="text" value="School" id="medical_school" name="medical_school"></td>
                            	<td>Degree Earned<input type="text" value="School" id="medical_degree" name="medical_degree"></td>
                            	<td>Graduation Date<input class="date" value="School"  type="text" id="medical_date" name="medical_date"></td>
                        	</tr>
                        
                        	<tr>
                        		<td>Residency Type
                                <select name="residency_type">
                                	<option value=""></option>
                                </select></td>
                            	<td>Sub specialty
                                	<select name="sub_specialty">
                                    	<option value=""></option>
                                    </select></td>
                        	</tr>
                        
                        	<tr>
                        		<td>Bord Certification<input value="School" type="text" id="board_certification" name="board_certification"></td>
                            	<td>Entity<input type="text" value="School" id="board_entity" name="board_entity"></td>
                            	<td>Year of Expiration<input value="School" type="text" id="board_expiration" name="board_expiration"></td>
                        	</tr>
                        
                        	<tr>
                        		<td>License Number<input type="text" value="School" id="license_number" name="license_number"></td>
                            	<td>State Issued <?php echo form_dropdown('license_state', get_states(), 'UT') ?></td>
                            	<td>DEA Number<input type="text" value="School" id="dea_number" name="dea_number"></td>
                        	</tr>
                        
                        	<tr>
                        		<td>Upload Photo (optional)<br /><input type="text" name="photo" placeholder="Image File"></td>
                                <td colspan="2"><br /><button id="upload">Browse</button></td>
                            
                        	</tr>
                        
                        	<tr>
                        		<td colspan="3">Biography<textarea name="biography" placeholder="write a little about yourself"></textarea></td>
                            
                        	</tr>
                    
                    	</table>
                        
                        </div>
                    
                   	</div><!--- practice information -->

					<div class="staff-information">
                    
                    	<div class="step3">
                    
						<h1 id="staff-information">Step 3: Staff Information</h1>
                    
                    	<p>Click the add button if you wish to add staff members to the account</p>
                        
                        <table class="staff-information-table" id="staff-information-table">
                        	<thead>
                            	<tr>
                                	<th>Name</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    
                    	<table>
                    		
                            <tr>
                        		<td>
                            		First Name
                                	<input type="text" value="School" id="staff_firstname" name="staff_firstname">
                            	</td>
                            	<td>
                            		Last Name
                                	<input type="text" value="School" id="staff_lastname" name="staff_lastname">
                            	</td>
                        	</tr>
                        
                        	<tr>
                        		<td>
                            		Primary Email
                                	<input type="text" value="School" id="staff_email" name="staff_email">
                            	</td>
                            	<td>
                            		Primary Phone Number
                                	<input type="text" value="School" name="staff_phone">
                            	</td>
                        	</tr>
                        
                        	<tr>
                        		<td>
                            		Upload Photo (optional)<br />
                                	<input type="text" name="staff_photo" placeholder="Image File">
                                </td>
                                <td>
                                	<br />
                                    <button id="staff_photo">Browse</button>
                               	</td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	<label>Account access: <input type="radio" name="staff_access" value="primary" checked="checked"> Primary access <input type="radio" value="secondary" name="staff_access"> Secondary access<label>
                            	</td>
                           
                        	</tr>
                        
                        	<tr>
                        		<td colspan="2">
                            		Staff Type
                                	<select id="staff_type" name="staff_type"><option value="Nurse Practioner">Nurse Practioner</option></select>
                            	</td>
                            
                        	</tr>
                    	
                        </table>
                    
                    	<table>
                    		<tr>
                        		<td>
                            		Undergrad School
                                	<input type="text" name="staff_undergrad_school">
                            	</td>
                            	<td>
                            		Degree Earned
                                	<input type="text" name="staff_undergrad_degree">
                            	</td>
                            	<td>
                            		Graduation Date
                                	<input class="date" type="text" name="staff_undergrad_date">
                            	</td>
                        	</tr>
                        
                        	<tr>
                        		<td>
                            		Professional Degree
                                	<input type="text" name="staff_professional_degree">
                            	</td>
                            	<td>
                            		State License
                                	<input type="text" name="staff_license">
                            	</td>
                            	<td>
                            		Board Certification
                                	<input type="text" name="staff_board_certification">
                            	</td>
                        	</tr>
                    	</table>
                    
                    	<a class="add-staff">+ add</a>
                        
                        </div>
                        
                        <div class="step4">
                        
					
                    	<h1>Step 4: Profile Information</h1>
                    
                    	<table class="profile-information-table">
                    		<tr>
                        		<td>
                            		Email Address (this will be your username)
                                	<input type="text" id="user_email" name="user_email">
                            	</td>
                           
                        	</tr>
                        
                        	<tr>
                        		<td>
                            		Verify email address
                                	<input type="text" id="verify_email" name="verify_email">
                            	</td>
                           
                        	</tr>
                        
                        	<tr>
                        		<td>
                            		Password
                                	<input type="password" id="password" name="password">
                            	</td>
                           
                        	</tr>
                        
                        	<tr>
                        		<td>
                            		Verify Password
                                	<input type="password" id="verify_password" name="verify_password">
                            	</td>
                           
                        	</tr>
                        
                        	<tr>
								<td style="height: 40px;">
									<span id="pass-strength-result"></span><br>
								</td>
							</tr>
                    	</table>
                        
                        </div>
                    
                    </div><!-- staff information -->
                    
                    <div class="license-agreement">
                    
                    	<div class="step5">
                    
                   	 	<h1>Step 5: Terms of Service</h1>
					
						<div class="license-agreement-window">
                    	
                        <p>This License is made on <?php echo date("M d, Y"); ?>, by and between RenewMyHealchcare.com (“Licensor”), a limited
liability company with its principal office in Flower Mound, Texas and [name] (“Licensee “).</p>
						<p><strong>ARTICLE 1: Recitals</strong></p>
                        <p>Licensor and Licensee acknowledge that:</p>
                        <p>Licensor is engaged in the Medical Practice of providing a medical services portal and healthcare prepayment services
through RenewMyHealchcare.com.</p>
                        <p>Such services are provided in connection with and through the use of various trade names, trademarks, and service
marks consisting of or containing the words “RenewMyHealchcare.com” and certain related words, letters, signs, and symbols (collectively “RenewMyHealchcare.com’s Names and Marks”).</p>
                        <p>Licensor has developed a unique and successful system for managing patient medical information and healthcare pricing and payment (referred to as the “Licensor's System”), which includes patient development, medical information methods, accounting methods, personnel training, and other matters relating to the efficient and successful operation of a medical practice.</p>
                        <p>Licensee desires to use RenewMyHealchcare.com’s Names and Marks and System, and to derive the benefits of Licensor's training, information, experience, advice, guidance, know-how and patient goodwill. The success of this system depends upon the continuing good reputation of each and every Medical Practice operated within it and upon the continuing goodwill of the public toward RenewMyHealchcare.com’s Names and Marks and the System. The success of both parties to this License and of the other Licensees is directly affected by the conduct of Licensee. Licensee, therefore, recognizes that adhering to the terms of this License is a matter of mutual covenant and of the highest importance and consequence to Licensee, Licensor, and all other Licensees.</p>
                        <p>Accordingly, in consideration of the foregoing recitals, of the mutual covenants hereafter set forth, and of other good
and valuable consideration, Licensor and Licensee agree as follows:</p>
                        <p>ARTICLE 2: Grant, Initial Fee, Term, and Renewal 2a. Grant of License</p>
                        <p>Licensor hereby grants to Licensee, and Licensee hereby accepts from Licensor, the right, License, and license, for
the term and upon the terms and purposes as follows:</p>
                        <p>(1) To utilize RenewMyHealchcare.com in accordance with this License and the Operations Guidelines;</p>
                        <p>(2) To use, in connection with the operation of the Medical Practice, RenewMyHealchcare.com’s Names and Marks and the System.
Provided, however, such right, License, and license shall be conditioned upon fulfilling the various requirements set out elsewhere in this License. </p>
                        <p>2b. Non-Exclusivity</p>
                        <p>The right, License, and license granted in this License shall be non- exclusive. Licensor shall at all times have the right to establish or operate itself, or to license any other party or parties to establish and operate any Medical Practice whatsoever at any other location or locations whatsoever, subject only to the limits of any territorial exclusivity hereinafter granted.</p>
                        <p>2c. Initial License Fee</p>
                        <p>Licensee shall pay to Licensor, as a part of the consideration for the execution of this License by Licensor and in addition to all other sums required to be paid by Licensee, an initial License fee in the sum of $_____________.</p>
                        <p>2d. Refunds</p>
                        <p>Except as otherwise provided for below, there shall be no refunds accorded to the Licensee.</p>
                        <p>2e. Term</p>
                        <p>Unless sooner terminated as provided in this License, this License shall remain in full force and effect for a period of two (2) years from the date of execution.</p>
                        <p>2f. Conditions Precedent</p>
                        <p>The Licensee shall be awarded the license granted in this License only after Licensee has performed the following conditions precedent:</p>
                        <p>(1) Demonstration of Licensee’s ability to perform pursuant to this License;</p>
                        <p>(2) Presented to Licensor satisfactory proof of a medical license and errors and omissions insurance; and</p>
                        <p>(3) Successfully completed training as set forth in this License.</p>
                        <p>At such time that Licensee has performed these conditions precedent, Licensor shall deliver to Licensee a License.</p>
                        <p>2g. Renewal</p>
                        <p>Provided that Licensee shall have complied with all of the terms and conditions of this License and any other agreement between Licensee and Licensor, then at the expiration of the License term, Licensor will offer Licensee the opportunity to remain a Licensee for one additional period of three (3) years, provided that:</p>
                        <p>(1) Licensee shall have demonstrated its ability to successfully implement the System.</p>
                        <p>(2) Licensee shall reimburse Licensor for the costs and other expenses, if any, incurred incident to the exercise of Licensee’s option.</p>
                        <p>(3) Licensee shall give Licensor written notice of Licensee’s desire to continue as a Licensee not less than ninety (90) days before this License expires.</p>
                        <p>Licensee is not required to pay any renewal fee.</p>
                        <p>ARTICLE 3: Names, Marks, and Confidential Information</p>
                        <p>3a. Validity and Use of RenewMyHealchcare.com’s Names and Marks</p>
                        <p>Licensee hereby acknowledges the validity of RenewMyHealchcare.com’s Names and Marks, and acknowledges that they are the sole property of RenewMyHealchcare.com, Ltd. Licensee shall use RenewMyHealchcare.com’s Names and Marks and the goodwill associated with them only for so long as the right, License, and license granted in this License remains in force, and only in connection with the conduct of the complete method of doing Medical Practice, performance of services, and sales of products licensed in this License, and only in the manner and for the purposes specified in this License. Licensee shall not, either during or after the term of this License, do anything or aid or assist any other party to do anything which would infringe upon, harm, or contest RenewMyHealchcare.com Ltd.'s rights in any of RenewMyHealchcare.com, Ltd.’s Names or Marks or in any other name or mark which incorporates the words “RenewMyHealchcare.com.”</p>
                        <p>3b. Designation of Medical Practice and Firm Name</p>
                        <p>Licensee shall not under any circumstance incorporate “RenewMyHealchcare.com” into the name of its practice or in any way cause confusion with the public that RenewMyHealthcare.com is practicing medicine in any manner.</p>
                        <p>3c. Ownership and Use of the Licensed Names and Marks</p>
                        <p>Licensee acknowledges that RenewMyHealchcare.com’s Names and Marks and the goodwill associated with them are RenewMyHealchcare.com’s exclusive property. Licensee shall not, either during or after the term of this License, utilize any of RenewMyHealchcare.com’s Names or Marks, or any and all names or marks confusingly similar thereto, except in accordance with the terms of this License. Licensee agrees that any further rights that may develop in any of RenewMyHealchcare.com’s Names and Marks in the future as trade names, trademarks, or service marks shall inure and accrue to the benefit of Licensor. Upon termination of this License for any reason, Licensee agrees to discontinue immediately all use of RenewMyHealchcare.com’s Names and Marks and that Licensee will not use any other trade name, trademark, sign, or other means of identification that might make it appear that Licensee is still licensed or authorized to operate a Licensed Medical Practice. Licensee agrees to reimburse Licensor for all costs, expenses, and attorney's fees incurred by Licensor to require Licensee to cease using RenewMyHealchcare.com’s Names and Marks, signs, or identification. The provisions of this paragraph shall survive termination of this License.</p>
                        <p>3d. Confidential Nature of the Licensed System</p>
                        <p>Licensee and, if applicable, its principal shareholders, members, or limited partners, acknowledge that Licensor is the sole owner of all proprietary rights in and to the Licensed System and each and every part of it, and all material and information now or hereafter revealed to Licensee under this License relative to the Licensed System. Licensee further acknowledges that the System, in its entirety, constitutes the proprietary information and trade secrets of Licensor which are revealed to Licensee in confidence, solely for the purpose of enabling Licensee to establish and operate the Licensed Medical Practice in accordance with the terms of this License. Such proprietary information and trade secrets include, but are not limited to, training manuals, policy manuals, Operations Guidelines, accounting procedures, marketing reports, informational bulletins, software and applications development, suppliers' discounts, and information management systems. Licensee agrees that both during and after the term of this License, (a) Licensee will not reveal any proprietary information or trade secrets to any other person, firm, or entity other than Licensee’s employees who require such information for the operation of the Licensed Medical Practice, and only to such extent, and (b) Licensee will not use any proprietary information or trade secrets in connection with any Medical Practice or venture in which Licensee has a direct or indirect interest, whether as proprietor, partner, joint venturer, shareholder, officer, director, or in any other capacity whatever, other than in connection with the operation of the Medical Practice licensed in this License.</p>
                        <p>Licensee acknowledges that (a) the methods of doing Medical Practice, services, processes, and other elements of the Licensed System are unique and distinctive and have been developed by Licensor at great effort, time, and expense; (b) the Licensee has regular and continuing access to valuable and confidential information, training, and trade secrets regarding the System; (c) as a result of the foregoing, it would be impossible for Licensee to engage in a similar Medical Practice without making use of or revealing Licensor's confidential information, procedures, and trade secrets; and (d) Licensee has an obligation to promote sales under the Licensed System. Accordingly Licensee and its principal shareholders agree that Licensor's information described above constitutes trade secrets belonging to Licensor.</p>
                        <p>In consideration of the Licensor's confidential disclosure of these trade secrets, Licensee agrees that during the term of this License, including any renewals or extensions, Licensee shall not, without Licensor's prior written consent, directly, indirectly, individually, or as a member of any Medical Practice organization, engage or have an interest in, as an employee, owner, investor, partner (inactive or otherwise), agent, stockholder, director, or officer of a corporation, or otherwise, any Medical Practice whose activities include services offered by the Licensed Medical Practice and which conducts such activities within the United States or its territories.</p>
                        <p>In the event Licensee is a corporation, limited liability company, or limited partnership, the foregoing restrictions shall
apply to each shareholder, member, manager, or limited partner. In the event Licensee is more than one person, the foregoing restrictions shall apply to them jointly and severally.</p>
                        <p>Licensee agrees that in the event of a breach of this Article, Licensor will be irreparably injured and without an adequate remedy at law. In such an event, Licensor will be entitled to a temporary, preliminary, and/or permanent injunction without the need to show actual or threatened harm or to post a bond or other security. This remedy shall be in addition to any other remedies Licensor may have under this License, at law or in equity, including the right to terminate the Agreement.</p>
                        <p>The restrictions contained in Article shall be severable, and the covenant not to compete shall be construed as an agreement independent of any other provision in this License. The existence of any claim or cause of action of the Licensee against Licensor shall not constitute a defense to the enforcement by Licensor of this covenant. To the extent this covenant not to compete depends for its enforcement on the reformation of either its geographical or durational scope, the parties agree that a court of competent jurisdiction should reform the geographical or durational scope so as to render the covenant enforceable.</p>
                        <p>3e. Goodwill</p>
                        <p>Licensee acknowledges that all goodwill which may arise from Licensee’s use of RenewMyHealchcare.com’s Names and Marks or the License System is and shall at all times remain the sole and exclusive property of Licensor and shall inure to the sole benefit of Licensor.</p>
                        <p>3f. Unauthorized Use</p>
                        <p>Licensee shall promptly report to Licensor any unauthorized use of the Licensor's Names or Marks that has come to Licensee’s attention in any manner whatsoever. If requested by Licensor, Licensee will cooperate with Licensor in precluding unauthorized use of  RenewMyHealchcare.com’s Names and Marks, or any confusingly similar name or mark, but at the sole expense of Licensor.</p>
                        <p>ARTICLE 4: Obligations of Licensor</p>
                        <p>4a. Services to be Rendered by Licensor</p>
                        <p>Licensor agrees that it will perform the following services for the benefit of the Licensee:</p>
                        <p>(1) Provide up to two employees of Licensee, at Licensee's expense, initial training in the methods and information 
described herein.</p>
                        <p>(2) Provide Licensee with certain guidelines and information that Licensor believes would be helpful to Licensee in the
use of the Licensed System.</p>
                        <p>(3) Make available to Licensee from time to time all improvements and additions to the Licensed System, to the same
extent and in the same manner as they are made available to Licensees generally.</p>
                        <p>(4) Provide Licensee with such written materials and/or manuals which become available to Licensor for operation of
the Medical Practice. Such materials shall be returned to Licensor upon termination of this License. Should Licensee,
for whatever reason, fail to return such materials, Licensee shall pay to Licensor the sum of $1,250.00 for its
replacement.</p>
                        <p>Additionally, Licensor may provide, at its option, from time to time, such additional training program or programs to
Licensee and each of Licensee’s employees as Licensor may reasonably designate. Licensee agrees to attend and to
cause all designated employees to attend such training program or programs. All expenses of travel, lodging, meals,
and other living expenses incurred by Licensee and/or such employees in attending such program or programs shall
be borne by Licensee.</p>
                        <p>ARTICLE 5: Royalties</p>
                        <p>5a. Payment of Royalty</p>
                        <p>Licensee agrees to pay to Licensor, at its offices at the address given above, [address].</p>
                        <p>ARTICLE 6: Training, Sales Programs, and Meetings</p>
                        <p>6a. Initial Training</p>
                        <p>Licensee shall not utilize the Licensed System without first attending and completing to Licensor's satisfaction the
RenewMyHealchcare.com training program. Licensee expressly understands and agrees that Licensor may require
Licensee to repeat so much of the initial program as Licensor may deem necessary to ensure Licensee’s satisfactory
completion. During the initial training program, Licensor shall provide Licensee instruction, training, and education in
the operation of such system.</p>
                        <p>6b. Additional Training and Sales Programs and Meetings</p>
                        <p>Licensee shall, solely at Licensee’s own expense, attend such additional training and sales programs and meetings at
such locations and at such times as Licensor may from time to time require unless non-attendance is authorized in
writing in advance by Licensor.</p>
                        <p>ARTICLE 7: Agreements of Licensee With Respect to Operation of Medical Practice</p>
                        <p>7a. Standards of Operation</p>
                        <p>Licensee will at all times (a) give prompt, courteous, and efficient service to the public; (b) practice in a medically
responsible manner; and (c) in all dealings with the members of the public, be governed by the highest standards of

honesty, integrity, fair dealing, and ethical conduct. Licensee will do nothing which would tend to discredit, dishonor,
reflect adversely upon, or in any manner injure the reputation of Licensor, Licensee, or any other Licensee.</p>
                        <p>7b. Insurance</p>
                        <p>Licensee will at Licensee’s sole expense, procure and maintain in force an errors and omissions insurance policy
issued by an insurance company authorized or admitted to issue such policies in the state of Licensee’s practice with a
Best's Insurance Rating of “A-” or better covering each medical professional associated with the Medical Practice in
any way, with Licensor as a named insured for bodily injury in the minimum amount of $1,500,000 per person and
$3,000,000 per occurrence. Licensee agrees to indemnify and hold Licensor harmless from any claims arising out of
the operation of the Medical Practice by Licensee or any employee, subcontractor, or agent of Licensee. These limits
of liability shall be increased and modified or additional types of coverage shall be obtained at Licensor's direction, as
and when changed circumstances reasonably require. The insurance policies shall expressly protect both Licensee
and Licensor and shall require the insurer to defend both Licensee and Licensor in any such action. Licensee shall
furnish to Licensor a certified copy or certificate with respect to each policy, evidencing coverage as set forth above,
and naming Licensor as an additional insured and providing that the policy shall not be canceled, amended, or
modified except upon ten (10) days prior written notice to Licensor. Maintaining the insurance required under this
Article shall not relieve Licensee of the indemnification obligations contained in this Paragraph. If Licensee fails to
procure or maintain in force any insurance as required by this Article or to furnish the certified copies or certificates
thereof required hereunder, Licensor may in addition to all other remedies, procure such insurance and/or certified
copies or certificates, and Licensee shall promptly reimburse Licensor for all premiums and other costs incurred in
connection with them.</p>
                        <p>7c. Compliance with Laws</p>
                        <p>Licensee shall comply with all federal, state, county, municipal, or other statutes, laws, ordinances, regulations, rules,
or orders of any governmental or quasi-governmental entity, body, agency, commission, board, or official applicable to
the Licensee’s Medical Practice. Nothing in this License shall prevent Licensee from engaging in a bona fide contest
of the validity or applicability thereof in any manner permitted by law.</p>
                        <p>7d. Licensee Not Agent of Licensor</p>
                        <p>this License does not in any way create the relationship of principal and agent or employer and employee between
Licensor and Licensee, and in no circumstances shall Licensee be considered an agent or employee of Licensor.</p>
                        <p>Licensee shall not act or attempt to act or represent Licensee directly or by implication as an agent of Licensor or in
any manner assume or create or attempt to assume or create any obligation on behalf of or in the name of Licensor,
nor shall Licensee act or represent Licensee as an affiliate of any other authorized Licensee.</p>
                        <p>7e. Compliance with Policies, Regulations, and Procedures</p>
                        <p>
Licensee shall at all times comply with all lawful and reasonable policies, regulations, and procedures promulgated or
prescribed from time to time by Licensor in connection with the Licensed System.</p>
                        <p>
7f. Participation in Advertising Programs</p>
                        <p>
With regard to the Licensed System, Licensee shall:</p>
                        <p>
(1) Participate in such advertising program or programs as Licensor may from time to time direct;</p>
                        <p>
(2) Use only such lineage, layout, copy, and content in such advertising as shall be approved by Licensor;</p>
                        <p>
(3) Not place or use any other advertising and not engage or participate in any other advertising program with respect
to the Licensed System without the express prior written approval of Licensor.</p>
                        <p>
Anything contained in any other provision in this License to the contrary notwithstanding, Licensee understands and
acknowledges that any advertising contributions collected by Licensor under this and other applicable Articles of this
License may be used by Licensor, in its sole and unfettered discretion, to develop such program or programs which it
may create for the benefit of Licensee. Any Advertising Contribution, if not paid when due, bears interest at an annual
rate of 12%. In the event that Licensee remits a check to Licensor that is returned due to insufficient funds, Licensee
shall be charged by Licensor a $25.00 service charge per check to cover the costs of re-depositing each check. In the
event that Licensee fails to make payments to Licensor for the advertising contributions more than thirty days after
such advertising contributions are due hereunder, Licensor may at its discretion terminate this License without
prejudice to its other remedies.</p>
                        <p>
ARTICLE 8: Transferability</p>
                        <p>
8a. General</p>
                        <p>
Licensee shall not make or suffer any assignment of this License or of any rights of interest herein. For all purposes
of this License, each of the following shall be deemed an assignment of this License:</p>
                        <p>
(1) Any sale, assignment, transfer, sub-License, or sub-license by Licensee of or with respect to this License or any
rights or interest in this License.</p>
                        <p>
(2) Any pledge, encumbrance, or grant of any security interest in this License by Licensee.</p>
                        <p>
(3) Sale at judicial sale or under power of sale, conveyance or retention of collateral in satisfaction of debt, or other
procedure to enforce the terms of any pledge, encumbrance, or security interest in this License which results in
disposition of Licensee’s interest in this License.</p>
                        <p>
(4) The passing by operation of law to any other party or parties of Licensee’s interest in this License or any part
thereof.</p>
                        <p>
(5) In the event Licensee is a corporation, partnership, or other form of Medical Practice association, any act,
transaction, or event of a nature described in paragraphs (1), (2), (3), or (4) above which, instead of operating upon
this License as such, operates upon or affects any interest in such corporation, partnership, or association and results
in any change in the present controlling interest in such corporation, partnership or association, whether by means of
one or a sequence of more than one transaction or event. If Licensee is two or more individuals, Licensee shall be
deemed to be a partnership for all purposes of this Article, irrespective of whether or not such individuals are
designated in this License as a partnership.</p>
                        <p>
(6) In the event Licensee ceases to comply with any one or more of the provisions prohibiting transfer, whether by
reason of voluntary action or inaction, disability, death, or other cause..</p>
                        <p>
Any assignment of this License whether voluntarily or involuntarily without the express, written consent of Licensor,
shall constitute a breach of this License and shall confer no rights or interests whatever under this License upon any
other party..</p>
                        <p>
8b. Death, Disability, Divorce.</p>
                        <p>
In the event of Licensee’s death, disability (including mental infirmity or incompetence), or divorce, if Licensee is an
individual, or, if Licensee is a corporation, partnership, or other form of association, then in the event of the death,
disability, or divorce of any party or parties owning an interest in Licensee, which results in the operation or day-to-day
management of the Medical Practice by an individual whose signature does not appear below, Licensor shall consent
to an assignment and transfer of this License to the executor, administrator, receiver, or other personal representative
of the deceased, disabled, or divorced individual and subsequently to the person or persons entitled to distribution as
the case may be, provided that each of the following conditions is fulfilled with respect to each assignment and
transfer:.</p>
                        <p>
(1) It shall be demonstrated to the reasonable satisfaction of Licensor that the executor, administrator, personal
representative, receiver, or distributee is capable of carrying out Licensee’s obligations and duties under this License.
(2) Any on-site manager who is designated pursuant to this Article shall have been approved by Licensor and shall
have successfully completed any training course provided in this License..</p>
                        <p>
(3) There shall not be any existing default in any of Licensee’s obligations under this License, and all amounts owed to
Licensor as of the date of death shall be paid in full..</p>
                        <p>
(4) The executor, administrator, personal representative, receiver, or distributee shall have submitted to Licensor
satisfactory evidence that such transferee has succeeded or otherwise become entitled to all rights of Licensee under
this License, or to all rights of the deceased in the License, as the case may be. If the deceased, disabled, or divorced
individual was Licensee, the executor, administrator, personal representative, receiver, or distributee shall have
executed and delivered to Licensor a written instrument, in a form satisfactory to Licensor, by which he or she

expressly assumes all of Licensee’s obligations under this License, and the successor in interest shall then be required
to execute Licensor's then current License for the full remaining term. If the deceased, disabled, or divorced individual
was the owner of an interest in the Licensee, the executor, administrator, personal representative, receiver, or
distributee shall execute and deliver to Licensor in a form satisfactory to Licensor a personal guarantee and a bond in
an amount sufficient to make Licensor whole for any breach of this License said bond being guaranteed by an
insurance company licensed to issue such bonds in the State of Texas as well as a subordination agreement..</p>
                        <p>
Any consent by Licensor to an assignment and transfer of the License or of any interest in Licensee to the executor,
administrator, receiver, or personal representative of the deceased shall not constitute a consent to any subsequent
assignment or transfer from the executor, administrator, receiver, or personal representative of the estate.
8c. Consent to Transfer of Managerial Responsibility.</p>
                        <p>
In the event any person responsible to discharge Licensee’s obligations under this License ceases to comply with any
one or more of the covenants and conditions as set out in this License, whether by reason of voluntary action or
inaction, disability, death, or other cause, Licensor shall consent to the designation by Licensee of a designated
manager, if in its reasonable discretion, Licensor finds such person or persons acceptable, provided, however, that he
or she shall successfully complete any training course required in this License and such designated manager agrees
to become bound by this License. Such designation shall not relieve Licensee of any obligation arising under this
License..</p>
                        <p>
8d. Failure of Licensor to Respond to Request for Consent to Transfer.</p>
                        <p>
In the event that Licensor fails or refuses to respond in writing to a request for any transfer, assignment, or designation
of a manager contemplated in the foregoing provisions within ten days of the written request by Licensee, its executor,
administrator, personal representative, receiver, or distributee, said request shall be deemed refused by operation of
this Article..</p>
                        <p>
8e. Assignability by Licensor.</p>
                        <p>
This License may be assigned by Licensor or by any successor, to any corporation which may succeed to the
business of Licensor or of such successor by sale of assets, merger, or consolidation, and may also be assigned by
Licensor or such successor to the shareholder or shareholders thereof in connection with any distribution of the assets
of the corporation or similar business association..</p>
                        <p>
ARTICLE 9: Default and Termination.</p>
                        <p>
9a. Termination by Event.</p>
                        <p>
(1) In the event Licensee fails to make any payment of money owed to Licensor when due, or fails to submit to
Licensor when due any report, writing, or information required by this License, and the default is not totally cured within
thirty (30) days after Licensor gives written notice to Licensee, then Licensor may terminate this License any time
thereafter by giving written notice of termination to Licensee..</p>
                        <p>
(2) In the event Licensee fails to perform any obligation imposed upon Licensee by this License within thirty (30) days
after Licensor gives written notice to Licensee, then Licensor may terminate this License at any time thereafter by
giving written notice to Licensee..</p>
                        <p>
(3) In the event Licensee has been given written notice of default by Licensor three (3) times within any period of six
(6) consecutive months pursuant to Paragraphs (1) and/or (2) above, and in each prior instance Licensee has cured
the default within the time permitted, then in the event Licensee again fails, within ninety days of the most recent
default, to perform any obligation referred to in Paragraphs (1) or (2), Licensor may at any time thereafter terminate
this License forthwith, without giving prior notice of such default and without affording Licensee any period within which
to cure the default, by giving written notice of such termination to Licensee..</p>
                        <p>
(4) Licensor may terminate this License forthwith, by giving written notice to Licensee, on account of any of the
following matters:.</p>
                        <p>
(i) Any willful or reckless falsification by Licensee of any report, statement, or other written data furnished to Licensor
without regard to the materiality of such falsification..</p>
                        <p>
(ii) Any willful and repeated refusal to honor any Licensor guarantee or any willful and repeated issuance of guarantees
.</p>
                        <p>
other than those permitted and authorized, if any, by Licensor..</p>
                        <p>
(iii) Any attempted or purported assignment of this License not in compliance with this License, provided that if
Licensor does not elect to exercise its right to terminate this License, such inaction shall not be deemed to constitute a
consent to the assignment nor to confer any rights or interests whatever upon the purported assignee. This License
shall remain binding and in full force and effect as between Licensor and Licensee unless and until Licensor elects to
terminate it..</p>
                        <p>
(iv) Any abandonment by Licensee of the Medical Practice licensed under this License or the loss of privileges to
practice medicine by Licensee..</p>
                        <p>
(v) Any willful, reckless, or repeated acts of malpractice, deception or dishonesty in dealings with patients, vendors, or
Licensor by Licensee..</p>
                        <p>
Any act or omission described in subparagraph (4) above shall be conclusively deemed to be willful and repeated if it
occurs after written notice from Licensor to cease and desist, but nothing in this sentence shall be construed to mean
that acts or omissions described in subparagraph (4) may not be considered to be willful and repeated in the absence
of notice from Licensor. Any notice of termination given by Licensor pursuant to this Paragraph (4) shall be fully
effective, and this License shall be terminated, notwithstanding that Licensee may have ceased engaging in or may not
at the time of such notice be engaged in, any of the acts which give rise to such notice, and notwithstanding that
Licensee may have taken steps to counteract the effects of any such acts..</p>
                        <p>
(6) This License shall terminate by operation of this paragraph in the event that the Licensed System is ever
determined to be unlawful or superceded by statute..</p>
                        <p>
9b. Automatic Termination.</p>
                        <p>
This License shall terminate immediately upon the occurrence of any of the following events, without the necessity of
notice of any kind by Licensor:.</p>
                        <p>
(1) The filing of bankruptcy or the appointment of any receiver, trustee, sequestrator, or similar officer to take charge of
Licensee’s Medical Practice, or any attachment, execution, levy, seizure, or appropriation by any legal process of
Licensee’s interest in this License, unless the appointment is vacated or discharged or the effect of such legal process
is otherwise released within thirty (30) days..</p>
                        <p>
(2) If Licensee is an individual, the conviction of, or a plea of guilty or no contest to, any crime for which the maximum
penalty includes imprisonment for one (1) year or more without regard to whether such maximum penalty is imposed..</p>
                        <p>
(3) If Licensee is a corporation, partnership, or other Medical Practice association, the occurrence of any act of a type
described in Paragraphs (1) or (2) above which relates to, involves, or affects the interest of any person owning a
controlling interest in Licensee..</p>
                        <p>
The right of Licensor to terminate this License whether or not exercised, shall not be exclusive of any other remedies
given Licensor by this License or by law on account of any default of Licensee under this License, and all obligations of
Licensee shall survive the termination of this License, save and except Licensee’s obligation to operate the Medical
Practice contemplated herein. Nothing in this License shall be construed to forgive or discharge any monetary
obligation of Licensee hereunder..</p>
                        <p>
9c. Relief in Equity Against Certain Defaults.</p>
                        <p>
Licensee agrees that neither termination of this License, nor any action at law, nor both, would be an adequate remedy
for a breach or default by Licensee, or by any other persons bound thereby, in the performance of any obligation
relating to RenewMyHealchcare.com or Licensor’s Names and Marks, the trade secrets revealed to Licensee in
confidence under this License, any Licensee guarantees, or the obligations of Licensee and such others upon and
after termination or allowed assignments of this License. It is agreed that in the event of any breach or default in
addition to all of the remedies provided elsewhere in this License or by law, Licensor shall be entitled to relief in equity
(including a temporary restraining order, temporary or preliminary injunction, and permanent mandatory or prohibitory
injunction), to restrain the continuation of any such breach or default or to compel compliance with such provisions of
this License..</p>
                        <p>

9d. Licensee’s Interest Upon Termination.</p>
                        <p>
Licensee has no interest in any goodwill of the trademarks, trade secrets, or systems upon termination or refusal to
renew or extend the License..</p>
                        <p>
9e. Obligations Upon and After Termination.</p>
                        <p>
Upon termination of this License, whether by lapse of time, by termination pursuant to any provision of this Article, by
mutual consent of the parties, by operation of law, or by any other manner, Licensee shall cease to be an authorized
Licensee as to any products or services whatever and Licensee and all persons directly or indirectly owning any
interest in the License or in any way associated with or related to Licensee shall:.</p>
                        <p>
(1) Promptly cause Licensee to pay Licensor all liquidated or ascertainable sums owing from Licensee to Licensor,
without setoff or other diminution, on account of unliquidated claims..</p>
                        <p>
(2) Immediately and permanently discontinue the use of any of RenewMyHealchcare.com’s Names and Marks, the
Licensed System, or any marks, names, or indicia which in the opinion of Licensor are confusingly similar thereto, or
any other material which may in any way indicate or tend to indicate that Licensee is or was an authorized Licensee or
is or was in any way associated with Licensor..</p>
                        <p>
(3) Immediately and permanently remove, destroy, or obliterate, at Licensee’s expense, all signs or materials
containing any of the Names or Marks or other things the use of which is prohibited by Paragraph (2) above, or sell to
Licensor at Licensor’s sole discretion, such materials prohibited by Paragraph (2) above, at a price equal to the original
cost to Licensee minus a reasonable allowance for depreciation, wear and tear, and obsolescence..</p>
                        <p>
(4) Promptly destroy or surrender to Licensor all stationery, letterheads, forms, printed matter, promotional displays,
and advertising containing any of RenewMyHealchcare.com’s Names and Marks or other things the use of which is
prohibited by Paragraph (2) above..</p>
                        <p>
(5) Immediately and permanently discontinue all advertising placed by Licensee as an authorized Licensee of Licensor
or which contains or makes reference to any of RenewMyHealchcare.com’s Names and Marks or other things the use
of which is prohibited by Paragraph (2) above, and will cancel all such advertising already placed or contracted for
which would otherwise be published, broadcast, displayed, or disseminated after the date of termination of this
License..</p>
                        <p>
(6) Immediately transfer and assign any telephone number, email addresses, or Internet domains for which Licensee
may be the subscriber, holder, owner, or assigned user and which shall have been listed or advertised by Licensee at
any time within the 24-month period prior to termination in any telephone directory or other medium in connection with
any of the Licensor's Names or Marks or any similar designation, to Licensor or to such person or firm as Licensor may
designate, and shall immediately execute such instruments, provide all passwords, and take such steps as in the
opinion of Licensor may be necessary or appropriate to transfer and assign each such telephone number, email
address, or Internet domain. Licensee further irrevocably appoints the then acting president of Licensor, or its
successor, as Licensee’s duly authorized agent and attorney-in-fact to execute all such instruments and take all such
steps to transfer and assign each telephone number, email address, or Internet domain..</p>
                        <p>
(7) Immediately and permanently discontinue any use of the word “RenewMyHealchcare.com” or any word confusingly
similar to it in Licensee’s firm name, corporate name, or trade name, and take the steps that may be necessary or
appropriate in the opinion of Licensor to change the names to eliminate the word “RenewMyHealchcare.com” or any
word confusingly similar to it..</p>
                        <p>
(8) Thereafter refrain from doing anything tending to indicate that Licensee is or was an authorized Licensee, or is or
was in any way associated with Licensor..</p>
                        <p>

9f. Covenant Not to Compete.</p>
                        <p>
In accordance with the language in this License, and the language stated in this Article, Licensee acknowledges that
Licensor is the sole owner of all proprietary rights in and to the Licensed System. Therefore, after the termination or
expiration of this License, for any reason by either party or both, Licensee shall not, directly or indirectly, individually or
as a member of any business organization, for a period of one (2) years from the effective date of termination of this
License, engage or have an interest in, as an employee, owner, investor, partner (inactive or otherwise), or agent, or
as a stockholder, director, or officer of a corporation, or otherwise, any business whose activities include a system
.</p>
                        <p>
which would compete with the Licensed System..</p>
                        <p>
However, in the event that Licensee competes as defined above in violation of this covenant, the two (2) year period of
non-competition shall extend past the anniversary date of termination of the Agreement for a period of time equal to
the duration of Licensee’s competition in violation of this covenant, but only to the extent necessary to ensure that
Licensee refrains from competition for a full two (2) year period and no longer..</p>
                        <p>
In the event Licensee is a corporation, the foregoing restrictions shall apply to each shareholder, and in the event
Licensee is more than one person, the foregoing restrictions shall apply to them jointly and severally; provided that the
foregoing restrictions shall not apply to investment in the shares of stock of a public company which at the time of
investment is listed on a recognized stock exchange so long as such shares of stock are listed..</p>
                        <p>
Licensee agrees that in the event of breach of this Article, Licensor will be irreparably injured and without an adequate
remedy at law. In that event, Licensor will be entitled to a temporary, preliminary and/or permanent injunction without
the need to show actual or threatened harm, said harm being agreed by Licensee by its execution of this License. In
the event that Licensor is entitled to any temporary, preliminary, and/or permanent injunction, Licensee agrees that a
reasonable bond required by Licensor in connection therewith shall not exceed $100.00. Licensee further agrees that
the reasonable bond for Licensee to post to set aside such injunction or restraining order shall be six times the
average monthly Gross Revenue as defined in this License or $250,000.00, whichever is higher. Licensee further
agrees that such bond must be paid into the registry of the Court in cash or issued by an insurance company
authorized or admitted to transact Medical Practice in Texas with a Best's Insurance Rating of “A-” or better and that
such bond shall be payable to Licensor if Licensor is the prevailing party in such litigation as that term is defined by
Texas law. This remedy shall be in addition to any other remedies Licensor may have under this License at law or in
equity including the right to terminate the Agreement..</p>
                        <p>
Licensee further agrees that as a condition precedent to filing suit to set aside any covenant not to compete or
covenant not to disclose trade secrets under this License, Licensee shall be required to post a bond equal to six times
the average Gross Revenue as defined in this License or $250,000.00, whichever is higher. Licensee further agrees
that such bond must be paid into the registry of the Court in cash or issued by an insurance company authorized or
admitted to transact Medical Practice in Texas with a Best's Insurance Rating of “A-” or better and that such bond shall
be payable to Licensor if Licensor is the prevailing party in such litigation as that term is defined by Texas law..</p>
                        <p>
Restrictions contained in this Article shall be severable and the covenant not to compete shall be construed as an
agreement independent of any other provisions in this License. The existence of any claim or cause of action of
Licensee against Licensor shall not constitute a defense to the enforcement by Licensor of the covenant. To the
extent the covenant not to compete depends for its enforcement on the reformation of either its geographical or
durational scope, the parties agree that a court of competent jurisdiction should reform the geographical or durational
scope so as to render the covenant enforceable..</p>
                        <p>
NO TERMINATION, DEFAULT, TRANSFER, ASSIGNMENT, OR EXPIRATION OF ANY OBLIGATION BY ANY
PARTY UNDER THIS LICENSE SHALL BE CONSTRUED TO WAIVE, FORGIVE, OR OTHERWISE SET ASIDE
ANY CONVENANT NOT TO COMPETE OR COVENANT NOT TO DISCLOSE TRADE SECRETS SET FORTH IN
THIS LICENSE. ANY PROVISION IN THIS LICENSE CONTRARY TO LICENSEE’S CONVENANT NOT TO
COMPETE OR COVENANT NOT TO DISCLOSE TRADE SECRETS SHALL BE, FOR THE PURPOSE OF
ENFORCING SAID COVENANTS ONLY, CONSTRUED, INTERPRETED, OR IGNORED TO THE EXTENT
NECESSARY TO ENFORCE LICENSEE’S CONVENANT NOT TO COMPETE OR COVENANT NOT TO DISCLOSE
TRADE SECRETS..</p>
                        <p>
9g. General Provisions Regarding Termination.</p>
                        <p>
(1) Termination of this License under any circumstances shall not abrogate, impair, release, or extinguish any debt,
obligation, or liability of Licensee to Licensor which may have accrued hereunder, including without limitation any such
debt, obligation, or liability which was the cause of termination or arose out of such cause..</p>
                        <p>
(2) All covenants and agreements of Licensee which by their terms or by reasonable implication are to be performed,
in whole or in part, after the termination of this License, shall survive termination..</p>
                        <p>
(3) Nothing contained in Article shall be deemed to apply to or affect the operation by Licensee or by any other party
.</p>
                        <p>
bound thereby of a Licensed Medical Practice at any other location pursuant to and in accordance with the provisions
of any other valid and outstanding agreement with Licensor..</p>
                        <p>
ARTICLE 10: Miscellaneous Provisions.</p>
                        <p>
10a. Grammar
The masculine of any pronoun shall include the feminine and/or the neuter thereof, and the singular of any noun or
pronoun shall include the plural, or vice versa, wherever the context shall require..</p>
                        <p>
10b. License
Upon any effective assignment of Licensee’s interest in this License any and all references herein to Licensee shall,
unless the context otherwise requires, mean and refer to such assignee..</p>
                        <p>
10c. Article Headings
Article headings are for convenience of reference only and shall not be construed as a part of this License, nor shall
they limit or define the meaning of any provision in this License..</p>
                        <p>
10d. Arbitration
In the event that Licensor is required participate in any arbitration, and, in the sole opinion of Licensor, Licensee is a
proper party to said arbitration, Licensor may at its sole discretion require Licensee to participate in such arbitration
without regard to any venue or choice of law provision within this License. In the event that Licensee fails to submit to
such arbitration or any arbitrator refuses to admit Licensee or allow Licensee to participate in any arbitration subject to
this Article, or any competent court deems Licensee’s participation in such arbitration to be improper, Licensor shall be
entitled to file suit against Licensee to enforce any obligation or indemnity agreement set forth in this License. Res
judicata shall not apply against Licensor as to any decision made against Licensor in any arbitration to which Licensee
did not submit nor shall Licensor be bound by any admission or testimony of Licensor, nor shall any admission or
testimony of any party arising out of any arbitration to which Licensee has not submitted be admissible (including
solely for the purpose of impeachment) against Licensor in any court of law..</p>
                        <p>
In the event that Licensor is subjected to any arbitration proceeding in which Licensor unsuccessfully attempts to
include Licensee, all applicable statutes of limitation shall be tolled to the later of (i) the date such limitations would be
tolled by operation of law; or (ii) the date that Licensor first attempted to include Licensee in such arbitration until ninety
days following said arbitration decision becoming final by operation of law..</p>
                        <p>
Notwithstanding the foregoing, nothing in this License shall be construed to create a general agreement to arbitrate
disputes arising out of this License..</p>
                        <p>
10e. Cost of Enforcement or Defense
In the event Licensor is required to employ legal counsel or to incur other expense to enforce any obligation of
Licensee under this License, or to defend against any claim, demand, action, or proceeding by reason of Licensee’s
failure to perform any obligation imposed upon Licensee by this License, and provided that legal action is filed by or
against Licensor in such action or the settlement thereof establishes Licensee’s default under this License, then
Licensor shall be entitled to recover from Licensee the amount of all reasonable attorney's fees of such counsel and all
other expenses reasonably incurred in enforcing such obligation or in defending against such claim, demand, action, or
proceeding, whether incurred prior to or in preparation for or contemplation of the filing or such action or thereafter and
without regard to whether such fees or expenses would ordinarily be recoverable at law..</p>
                        <p>
10f. Remedies Cumulative
All rights and remedies conferred upon Licensor by this License and by law shall be cumulative of each other, and
neither the exercise nor the failure to exercise any such right or remedy shall preclude the exercise of any other such
right or remedy..</p>
                        <p>
10g. Non-Waiver
No failure by Licensor to take action on account of any default by Licensee, whether in a single instance or repeatedly,
shall constitute a waiver of any such default or of the performance required of Licensee. No express waiver by
Licensor of any provision or performance under this License or of any default by Licensee shall be construed as a
waiver of any other or future provision, performance, or default..</p>
                        <p>

10h. Validity
If any provision of this License shall be invalid or unenforceable, either in its entirety or by virtue of its scope or
application to given circumstances, such provision shall be deemed modified to the extent necessary to render it valid,
or as not applicable to given circumstances, or to be excised from this License, as the situation may require, and this
License shall be construed and enforced as if the provision had been included in this License, as the case may be, it
being the stated intention of the parties that, had they known of the invalidity or unenforceability at the time of entering
into this License, they would have nevertheless contracted upon the Agreement's terms, either excluding such
provisions, or including such provisions only to the maximum scope and application permitted by law, as the case may
be. In the event the total or partial invalidity or unenforceability of any provision of this License exists only with respect
to the laws of a particular jurisdiction, this Article 11[h] shall operate upon the provision only to the extent that the laws
of the jurisdiction are applicable to the provision..</p>
                        <p>
10i. Notices
Any notice or demand given or made pursuant to the terms of this License shall be served in the following manner:
(1) If given to Licensor, it shall be sent by United States registered or certified mail, postage fully prepaid, addressed to
________________________________________________________________ [Licensor's name, address, city,
state, and zip code], or to such changed address or addresses as Licensor may from time to time designate..</p>
                        <p>
(2) If given to Licensee, it shall either be delivered personally to the person (or any one of the persons) whose
signatures appear below (of the assignee thereof), or shall be sent by United States registered or certified mail,
postage fully prepaid, addressed to Licensee at the address of Licensee’s Medical Practice. Any such notice or
demand shall be deemed to have been given or made and shall be deemed effective when it has been received,
provided that any notice pursuant to this License shall be deemed to have been made or given and shall be deemed
effective when mailed in accordance with this Article, provided that it is received by Licensor within five (5) Medical
Practice days after expiration of the period for making or giving the demand or notice..</p>
                        <p>
10j. Entire Agreement
This License constitutes and contains the entire agreement and understanding of the parties with respect to its subject
matter. There are no representations, undertakings, agreements, terms, or conditions not contained or referred to in
this License..</p>
                        <p>
10k. Binding Effect
Subject to all the provisions regarding assignments, and without waiver or modification thereof, this License shall be
binding upon and shall inure to the benefit of the parties hereto (including the parties whose signatures follow those of
Licensor and Licensee ) and their respective heirs, executors, administrators, personal representatives, successors,
and assigns..</p>
                        <p>
10l. Controlling Law
This License, including all matters relating to the validity, construction, performance, and enforcement thereof, shall be
governed by the laws of the State of Texas..</p>
                        <p>
The foregoing notwithstanding, to the extent that the provisions of this License provide for periods of notice less than
those required by applicable law, or provide for termination, cancellation, non-renewal or the like other than in
accordance with applicable law, the provisions shall, to the extent they are not in accordance with applicable law, not
be effective, and Licensor shall comply with applicable law in connection with each of these matters..</p>
                        <p>
10m. Jurisdiction and Venue
All claims, suits or causes of action arising directly or indirectly from this License shall be brought exclusively in the
District Courts of Denton County, Texas, and the parties hereby consent to personal jurisdiction and venue in that
forum..</p>
                        <p>
10n. Counterparts
This License may be executed in any number of identical counterparts, and each counterpart shall be deemed a
duplicate of the original..</p>
                        <p>
Executed at ____________________, Texas, on ___________________[date ]..</p>
                        <p>

LICENSOR
___________________________ [name of Licensor ].</p>
                        <p>
By: _______________________________[signature ].</p>
                        <p>
_______________________________ [printed name ].</p>
                        <p>
___________________________ [title, e.g., President].</p>
                        <p>
LICENSEE
___________________________ [name of Licensee ].</p>
                        <p>
By: _______________________________[signature ].</p>
                        <p>
_______________________________ [printed name ].</p>
                        <p>
___________________________ [title, e.g., President].</p>
                        <p>
                    	
                        </div>
                        
                     	 <div class="agree">
                         
                         	<div><!-- extra -->
                     		
                            	<div><!-- extra -->
                                
                                	<div><!-- extra -->
                     		
                            		I have read and agree to the terms and conditions.<br />
                     
                     				<input type="radio" name="agree" value="1" checked="checked"> I agree
                        
                        			<input type="radio" name="agree" value="0"> I do not agree

									</div><!-- extra -->
                     
                     			</div><!-- extra -->
                                
                             </div><!-- extra -->
                        
                        </div>
                        
                        </div><!--- step 5 -->
                     
                     	</div><!-- license agreement -->
                        
                        <div class="account-summary">
                        
                        	<div class="step6">
                            
                            	<h1>Step 6: Account Summary</h1>
                                
                                                               
                                <h2>Practice Information</h2>
                                
                                <div class="practice-information"></div>
                                
                                <h2>Doctor Information</h2>
                                
                                
                                <div class="doctor-information"></div>
                                
                                <h2>Staff Information</h2>
                                
                                <div class="staff-information"></div>
                                
                                <h2>Profile Information</h2>
                                
                                <div class="profile-information"></div>
                            
                            </div>
                        
                        </div>
                     
                     <div class="buttons" style="text-align:right;">
                     	<a class="next"></a>
                        <a class="button">Submit</a>
                     </div>
                     
                    
                     </form>
                     
				</div>
				
                
                	 <div class="steps">
                     	<div class="step1 current">
                        	Step 1:<br />Practice Information<br />                        	
                            <span class="right"></span>
                            <span class="number">1</span>
                        </div>
                        <div class="step2">
                        	Step 2:<br />Doctor Information<br />
                            <span class="left"></span>
                            <span class="right"></span>
                        	<span class="number">2</span>
                            
                        </div>
                        <div class="step3">
                        	Step 3:<br />Staff Information<br />
                        	<span class="left"></span>
                            <span class="right"></span>
                        	<span class="number">3</span>                            
                        </div>
                        <div class="step4">
                        	Step 4:<br />Create Your Profile<br />
                        	<span class="left"></span>
                            <span class="right"></span>
                        	<span class="number">4</span>                            
                        </div>
                        <div class="step5">
                        	Step 5:<br />Terms of Service<br />
                        	<span class="left"></span>
                            <span class="right"></span>
                        	<span class="number">5</span>                           
                        </div>
                        <div class="step6">
                        	Step 6:<br />Account Summary<br />
                        	<span class="left"></span>
                           	<span class="number">6</span>
                        </div>
                     </div>
                     
                     <br clear="all">
					
				<footer>
					<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>
					<p><?php the_tags(); ?></p>
				</footer>

			</article>
		<?php endwhile;?>

		<?php do_action('foundationPress_after_content'); ?>

		</div>
		<?php get_sidebar(); ?>
		
	</div>
</div>

</div><!--- doctor enrollment page -->

<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url') ?>/js/jquery-ui-1.11.1.custom/jquery-ui.css">
<script type="text/jscript" src="<?php bloginfo('template_url') ?>/js/jquery-ui-1.11.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/ajaxupload.js"></script>
<script type="text/javascript"><!--
new AjaxUpload('#upload', {
	action: 'upload.php',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('input[name=photo]').val('uploading...');
	},
	onComplete: function(file, json) 
	{
		if (json['success'])
		{
			$('input[name=photo]').val(file);
		}
		
		if (json['error'])
		{
			$('input[name=photo]').val('');
			alert(json['error']);
		}
	}
});
//--></script>

<script type="text/javascript"><!--
new AjaxUpload('#staff_photo', {
	action: 'upload.php',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('input[name=staff_photo]').val('uploading...');
	},
	onComplete: function(file, json) 
	{
		if (json['success'])
		{
			$('input[name=staff_photo]').val(file);
		}
		
		if (json['error'])
		{
			$('input[name=staff_photo]').val('');
			alert(json['error']);
		}
	}
});
//--></script>

<script>

var staff_counter = 0;
var email_ok = 1;

jQuery('.date').datepicker();


function verify_doctor_email_address(email)
{
	var ok = function()
	{
		$.ajax(
		{
			url: 'wp-content/themes/FoundationPress-master/parts/account_registration_check.php',
			type: 'post',
			dataType: 'html',
			data: 'email=' + email + '&username=' + email,
			success:function(data)
			{
				if (data != 11)
				{
					$('#user_email').after('<span class="warning">Email is not valid</span>');
					return 0;
				}
				else
				{
					$('.warning').remove();
					return 1;
				}
			}
		});
	}
	
	return ok;
	
}


function showSteps(step)
{
	console.log(step);
	
	$('.steps > div').removeClass('current');
	$('.steps > div').removeClass('prev');
	
	if (step == 'step1')
	{
		$('.steps > div.step1').addClass('current');
	}
	else if (step == 'step2')
	{
		$('.steps > div.step1').addClass('prev');
		$('.steps > div.step2').addClass('current');	
	}
	else if (step == 'step3')
	{
		$('.steps > div.step1').addClass('prev');
		$('.steps > div.step2').addClass('prev');	
		$('.steps > div.step3').addClass('current');	
	}
	else if (step == 'step4')
	{
		$('.steps > div.step1').addClass('prev');
		$('.steps > div.step2').addClass('prev');	
		$('.steps > div.step3').addClass('prev');	
		$('.steps > div.step4').addClass('current');	
	}
	else if (step == 'step5')
	{
		$('.steps > div.step1').addClass('prev');
		$('.steps > div.step2').addClass('prev');	
		$('.steps > div.step3').addClass('prev');	
		$('.steps > div.step4').addClass('prev');	
		$('.steps > div.step5').addClass('current');	
	}
	else if (step == 'step6')
	{
		build_doctor_account_summary();
		
		$('.steps > div.step1').addClass('prev');
		$('.steps > div.step2').addClass('prev');	
		$('.steps > div.step3').addClass('prev');	
		$('.steps > div.step4').addClass('prev');	
		$('.steps > div.step5').addClass('prev');	
		$('.steps > div.step6').addClass('current');
		
	}
	
}

function build_doctor_account_summary()
{
	var practice_information = '';
	var doctor_information = '';
	var profile_information = '';
	var staff_information = '';
	
	var practice_name = $('input[name=practice_name]').val();
	var practice_phone = $('input[name=practice_phone]').val();
	var practice_email = $('input[name=practice_email]').val();
	var practice_city = $('input[name=practice_city]').val();
	var practice_state = $('input[name=practice_state]').val();
	var practice_zip = $('input[name=practice_zip]').val();
	
	practice_information = '<table>';
	
	practice_information += '<tr>';
	
	practice_information += '<td colspan="3">Name</td><td>Primary Phone</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>'
	
	practice_information += '<td colspan="3">' + practice_name + '</td>';
	
	practice_information += '<td>' + practice_phone + '</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>';
	
	practice_information += '<td colspan="3">Address</td><td>Primary Email</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>';
	
	practice_information += '<td colspan="3">' + $('input[name=practice_address]').val() + '</td><td>' + practice_email + '</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>';
	
	practice_information += '<td colspan="3">Address 2</td><td>Routing Number</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>';
	
	practice_information += '<td colspan="3">' + $('input[name=practice_address2]').val() + '</td><td>' + $('input[name=practice_routing_number]').val() + '</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>';
	
	practice_information += '<td>City</td><td>State</td><td>Zip</td><td>Bank Account</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>';
	
	practice_information += '<td>' + practice_city + '</td><td>' + $('select[name=practice_state] option:selected').text() + '</td><td>' + $('input[name=practice_zip]').val() + '</td><td>' + $('input[name=practice_bank_account]').val() + '</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>';
	
	practice_information += '<td colspan="4">Number of doctors</td>';
	
	practice_information += '</tr>';
	
	practice_information += '<tr>';
	
	practice_information += '<td colspan="4">' + $('select[name=practice_doctors] option:selected').text() + '</td>';
	
	practice_information += '</tr>';
	
	practice_information += '</table>';
	
	doctor_information = '<table>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>First Name</td><td>Last Name</td><td>Mobile Number</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>' + $('input[name=firstname]').val() + '</td><td>' + $('input[name=lastname]').val() + '</td><td>' + $('input[name=cellphone]').val() + '</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td colspan="3">Email</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td colspan="3">' + $('input[name=email]').val() + '</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>Undergrad School</td><td>Degree Earned</td><td>Graduation Date</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>' + $('input[name=undergrad_school]').val() + '</td><td>' + $('input[name=undegrad_degree]').val() + '</td><td>' + $('input[name=undergrad_date]').val() + '</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>Medical School</td><td>Degree Earned</td><td>Graduation Date</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>' + $('input[name=medical_school]').val() + '</td><td>' + $('input[name=medical_degree]').val() + '</td><td>' + $('input[name=medical_date]').val() + '</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>Residency Type</td><td>Sub Specialty</td><td>&nbsp;</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>' + $('select[name=residency_type] option:selected').text() + '</td><td>' + $('select[name=sub_specialty] option:selected').text() + '</td><td>&nbsp;</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>Board Certification</td><td>Entity</td><td>Year of expiration</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>' + $('input[name=board_certification]').val() + '</td><td>' + $('input[name=board_entity]').val() + '</td><td>' + $('input[name=board_expiration]').val() + '</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>License Number</td><td>State Issued</td><td>DEA Number</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td>' + $('input[name=license_number]').val() + '</td><td>' + $('select[name=license_state] option:selected').text() + '</td><td>' + $('input[name=dea_number]').val() + '</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td colspan="3">Biography</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '<tr>';
	
	doctor_information += '<td colspan="3">' + $('textarea[name=biography]').val()+ '</td>';
	
	doctor_information += '</tr>';
	
	doctor_information += '</table>';
	
	
	
	profile_information = '<table>';
	
	profile_information += '<tr>';
	
	profile_information += '<td>Email Address / Username</td><td>Password</td>';
	
	profile_information += '</tr>';
	
	profile_information += '<tr>';
	
	profile_information += '<td>' + $('input[name=user_email]').val() + '</td><td>---</td>';
	
	profile_information += '</tr>';
	
	profile_information += '</table>';
	
	staff_information = '<table>';
	
	staff_information += '<tr>';
	
	staff_information += '<td>Name</td><td>Type</td>';
	
	staff_information += '</tr>';
	
	if (staff_counter > 0)
	{
		$('.staff-information-table tbody tr').each(function()
		{
			var inp = $('input', this);
			staff_information += '<tr>';
			staff_information += '<td>' + $(this).find(inp[0]).val() + '</td>';
			staff_information += '<td>' + $(this).find(inp[1]).val() + '</td>';
			staff_information += '</tr>'
		});
	}
	else
	{
		staff_information += '<tr>';
		staff_information += '<td colspan="2" align="center"> - no staff - </td>';
		staff_information += '</tr>';
	}
	
	staff_information += '</table>';
	
	$('.account-summary .practice-information').html(practice_information);
	$('.account-summary .doctor-information').html(doctor_information);
	$('.account-summary .profile-information').html(profile_information);
	
	$('.account-summary .staff-information').html(staff_information);
}

$(document).ready(function()
{
	//build_doctor_account_summary();
		
	$('.doctor-enrollment input').bind('focus click change', function()
	{
		var step = $(this).parent().parent().parent().parent().parent().attr('class');
	
		showSteps(step);
	});
});
</script>

<?php get_footer(); ?>
