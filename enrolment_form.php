<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.




/**
 * Authorize.net enrolment plugin - enrolment form.
 *
 * @package    enrol_authorizedotnet
 * @author     DualCube <admin@dualcube.com>
 * @copyright  2021 DualCube (https://dualcube.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
global $PAGE;
$login_id = $this->get_config('loginid');
$transaction_key = $this->get_config('transactionkey');
$client_key = $this->get_config('clientkey');
$auth_mode = $this->get_config('checkproductionmode');
$amount = $cost;
$description = $coursefullname;
$invoice = date('YmdHis');
$sequence = rand(1, 1000);
$timestamp = time();
$error_payment_text = get_string('error_payment', 'enrol_authorizedotnet');
$requiredmissing = get_string('requiredmissing', 'enrol_authorizedotnet');
?>
<!-- Load the jQuery library from the Google CDN -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<div class="payment-wrap">
  <div class="authorize-img-wrap">
    <div class="authorize-img">
      <img src="<?php echo $CFG->wwwroot; ?>/enrol/authorizedotnet/pix/authorize-net-logo.jpg">
    </div>
  </div>
  <div class="order-info">
    <b class='heading-athorzed'>Order Info</b>
    <div class="form-group-authorized-net">
      <label for="card-number"><b>Cost :</b></label>
      <div class="authorized-net-input-wrap">
    <p><b><?php echo " {$instance->currency} {$localisedcost}"; ?></b></p>
      </div>
    </div>
  </div>
  <div class='payment-info-authorized'>
    <b class='heading-athorzed'>Payment Info</b>
      <div class="authorize-card-img"><img src="<?php echo $CFG->wwwroot; ?>/enrol/authorizedotnet/pix/paynow.png"></div>
      <!-- card number -->
    <div class="form-group-authorized-net">
      <label for="card-number">Card Number</label>
      <span class="requiredstar">*</span> 
      <div class="authorized-net-input-wrap">
      <input type="text" name="cardNumber" id="card-number" placeholder="<?php echo get_string('cardnumberex', 'enrol_authorizedotnet'); ?>"/><div><?php echo get_string('cardnumberreq', 'enrol_authorizedotnet'); ?></div>
      </div>
    </div>
    <!-- exp date -->
    <div class="form-group-authorized-net">
      <label for="">Exp Date</label>
      <span class="requiredstar">*</span> 
      <div class="authorized-net-input-wrap exp-date">
        <input type="text" name="expMonth" id="exp-month" placeholder="<?php echo get_string('expmonthex', 'enrol_authorizedotnet'); ?>"/>
        <input type="text" name="expYear" id="exp-year" placeholder="<?php echo get_string('expyearex', 'enrol_authorizedotnet'); ?>"/><div>(mm yyyy)</div>
      </div>
    </div>
    <!-- card code -->
    <div class="form-group-authorized-net">
      <label for="card-coder">Card Code</label>
      <span class="requiredstar">*</span>
      <div class="authorized-net-input-wrap">
      <input type="text" name="cardCode" id="card-code" placeholder="<?php echo get_string('cardcodeex', 'enrol_authorizedotnet'); ?>"/>
    <div> <a href="">what's that</a></div>
  </div>
    </div>
  </div>
  <div class='billing-info-athorized'>
    <b class='heading-athorzed'>Billing Info</b>
    <!-- first name -->
    <div class="form-group-authorized-net">
      <span class="requiredstar">*</span>
      <label for="First Name"><?php echo get_string('firstname', 'enrol_authorizedotnet'); ?></label>
      <input type="text" name="First Name" id="firstname" placeholder="<?php echo get_string('firstname', 'enrol_authorizedotnet'); ?>">
    </div>
    <!-- last name -->
    <div class="form-group-authorized-net">
      <span class="requiredstar">*</span>
      <label for="Last Name"><?php echo get_string('lastname', 'enrol_authorizedotnet'); ?></label>
      <input type="text" name="Last Name" id="lastname" placeholder="<?php echo get_string('lastname', 'enrol_authorizedotnet'); ?>">
    </div>
    <!-- Address -->
    <div class="form-group-authorized-net">
      <span class="requiredstar">*</span>
      <label for="Address"><?php echo get_string('address', 'enrol_authorizedotnet'); ?></label>
      <input type="text" name="Address" id="address" placeholder="<?php echo get_string('addressex', 'enrol_authorizedotnet'); ?>">
    </div>
    <!-- zip -->
    <div class="form-group-authorized-net">
      <span class="requiredstar">*</span>
      <label for="ZIP Code"><?php echo get_string('ZIP', 'enrol_authorizedotnet'); ?></label>
      <input type="text" name="ZIP Code" id="zip" placeholder="<?php echo get_string('ZIPex', 'enrol_authorizedotnet'); ?>">
    </div>
  </div>
  <div class="auth-submit">
    <div class="loader"></div>
    <div id="payment_error"></div>
    <div id="error_massage"></div>
    <button type="button" id="final-payment-button"><?php echo get_string('pay', 'enrol_authorizedotnet'); ?></button>
  </div>
</div>
<?php
$PAGE->requires->js_call_amd('enrol_authorizedotnet/authorizedotnet_payments', 'authorizedotnet_payments', array($client_key, $login_id, $amount, $instance->currency, $transaction_key, $instance->courseid, $USER->id, $USER->email, $instance->id, $context->id, $description, $invoice, $sequence, $timestamp, $auth_mode, $error_payment_text, $requiredmissing));
?>
<style>
.payment-wrap {
    width: 85%;
    margin: auto;
    padding-top: 2rem;
}
 div#payment_error p {
    text-align: center;
}
.payment-info-authorized input {
    border-radius: 0.25rem;
    padding: 0.25rem 1rem;
    width: 100%;
}
.form-group-authorized-net label {
  width: 25%;
    text-align: right;
}
.authorized-net-input-wrap.exp-date input {
  width: 49%;
}
.authorized-net-input-wrap {
    width: 50%;
}
.authorize-img {
    width: 35%;
}
.authorize-img img {
    object-fit: cover;
    object-position: center;
    height: 100%;
    width: 100%;
}
.heading-athorzed {
    border-bottom: 0.06rem solid #eee;
    display: block;
    text-align: left;
    font-size: 1rem;
    padding: 0.5rem;
}
.authorize-img-wrap {
      display: flex;
    align-items: center;
    justify-content: space-between;
    flex-direction: column;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 0rem 0 3rem;
}
.authorize-card-img{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-direction: column;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1rem 0 0;
}
.billing-info-athorized input {
    border-radius: 0.25rem;
    padding: 0.25rem 1rem;
    width: 50%;
}
.requiredstar {
    position: absolute;
    left: 25%;
    top: 0;
    color:#ff0000;
}
.form-group-authorized-net {
    display: flex;
    position: relative;
    margin: 1.5rem 0;
    gap: 1.5rem;
}
.auth-submit #final-payment-button {
    color: #fff;
    background-color: #1177d1;
    border: 0;
    padding: 5px 32px;
    border-radius: 0.25rem;
    font-size: 20px;
    box-shadow: 0 0.125rem 0.25rem #645cff2e;
    width: 32%;
}
.auth-submit {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 0.06rem solid #eee;
}
.loader {
  margin: auto;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}
@media only screen and (max-width: 700px) {
  .generalbo {
    width: auto;
}
.form-group-authorized-net label {
    text-align: left;
}
.authorized-net-input-wrap.exp-date input {
    width: 48%;
}
}
/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>