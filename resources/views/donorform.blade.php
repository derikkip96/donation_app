
<form id="rightcol" action="{{route('iframe_pay')}}" method="post">
    @csrf
    <table>
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="first_name" value="" /></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="last_name" value="" /></td>
        </tr>
        <tr>
            <td>Email Address:</td>
            <td><input type="email" name="email" value="" /></td>
        </tr>
        <tr>
            <td>Phone Number:</td>
            <td><input type="text" name="phone_number" value="" /></td>
        </tr>
        <tr>
            <td>Amount:</td>
            <td>
                <select name="currency" id="currency">
                    <option value="KES">Kenya shillings</option>  
                    <option value="UGX">Ugandan Shillings</option> 
                    <option value="TZS">Tanzanian shillings</option>  
                    <option value="USD">US Dollars</option>  
                </select>
                <input type="text" name="amount" value="" />
            </td>
        </tr>
        <tr><td colspan="2"><hr /></td></tr>
        <tr>
            <td>Description:</td>
            <td><input type="text" name="description" value="Payments for donation" /></td>
        </tr>
        <tr><td colspan="2"><hr /></td></tr>
        <tr>
            <td colspan="2"><input type="submit" value="Make Payment" class="btn" /></td>
        </tr>
    </table>
</form>
