<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seamless Wallet 2.0 Documentation</title>
    <link rel="stylesheet" href="/assets/css/styledocs.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Seamless Wallet 1.0 Documentation</h1>
            <!-- <span class="version">[v1.0.2]</span> -->
            <a href="/docs/test" class="back-link">[Go to test API]</a>
        </header>

        <section>
            <h2>What is Seamless Wallet?</h2>
            <p>Seamless wallet allows your players to play seamlessly across all of our products from the account and credit that they already registered on your site.</p>
            <p>If you are interested in this feature, please contact us for further assistance.</p>
        </section>

        <section>
            <h2>Get member balance</h2>
            <p>We will use this API to get member's balance.</p>
            <p class="note">You have to implement this API to handle our request. Please implement the ResponseBody as the example below.</p>

            <table class="api-table">
                <tr>
                    <th>Name</th>
                    <th>Sample</th>
                </tr>
                <tr>
                    <td>Path</td>
                    <td>{Your domain}/GetBalance</td>
                </tr>
                <tr>
                    <td>Method</td>
                    <td>POST</td>
                </tr>
                <tr>
                    <td>Header</td>
                    <td>Content-type : application/json; charset=UTF-8</td>
                </tr>
                <tr>
                    <td>RequestBody</td>
                    <td>
                        <pre>
{
    "CompanyKey":"AXzoeJ3YKhBkRZU57SVXOb4qrx1Kmht5lrzzUBrfkxMY7kokwQyE6F3ILPGM",
    "Username":"Player01"
}
                        </pre>
                </td>
                </tr>
                <tr>
                    <td>ResponseBody</td>
                    <td>
                        <pre>
{
    "AccountName":"Player01",
    "Balance":"5000000.00",
    "ErrorCode":0,
    "ErrorMessage":"No Error"
}
                        </pre>
                    </td>
                </tr>
            </table>
        </section>
        <section>
            <h2>Deduct stake</h2>
            <p>We will use this API to inform you to deduct the user's stake when bet is placed by member.</p>
            <p class="warning">We will reject user's bet if the errorCode is not 0 from your response.</p>
            
            <!-- <div class="product-specific-rules">
                <p>This API may be requested by many times under the same bet, which means that user raise their bet.</p>
                <p>In different product type Deduct api has different logic:</p>
                <ul>
                    <li>In sports, the same transferCode can't Deduct twice.</li>
                    <li>In Casino and RNG Games, the same transferCode can Deduct twice, but 2nd Deduct amount must be greater than 1st Deduct.</li>
                    <li>In VirtualSports, the same transferCode can't Deduct twice.</li>
                    <li>In 3rd Man Wei, the same transferCode and same transactionId can't Deduct twice, but same transferCode can Deduct another transactionId.</li>
                </ul>
            </div> -->

            <p class="note">You have to implement this API to handle our request. Please implement the ResponseBody as the example below.</p>

            <table class="api-table">
                <tr>
                    <th>Name</th>
                    <th>Sample</th>
                </tr>
                <tr>
                    <td>Path</td>
                    <td>{Your domain}/Deduct</td>
                </tr>
                <tr>
                    <td>Method</td>
                    <td>POST</td>
                </tr>
                <tr>
                    <td>Header</td>
                    <td>Content-type : application/json; charset=UTF-8</td>
                </tr>
                <tr>
                    <td>RequestBody</td>
                    <td>
                        <pre>
{
    "CompanyKey":"AXzoeJ3YKhBkRZU57SVXOb4qrx1Kmht5lrzzUBrfkxMY7kokwQyE6F3ILPGM",
    "TransactionCode" : "B532770",
    "Username" : "Player01",
    "Amount" :  50000,
    "GameId" : 1
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <td>ResponseBody</td>
                    <td>
                        <pre>
{
    "AccountName": "Player01",
    "Balance": "4950000.00",
    "ErrorCode": 0,
    "ErrorMessage": "No Error",
    "BetAmount":50000
}
                        </pre>
                    </td>
                </tr>
            </table>
        </section>
        <section>
            <h2>Settle bet</h2>
            <p>We will use this API to send the result of bet for you to settle the bet.</p>
            <p>Please noted that we might resettle the bet when needed.</p>
            <p>You need to handle the case for us.</p>

            <div class="product-specific-rules">
                <p>When we settle the bet:</p>
                <ul>
                    <li>The bet should be in running status at first.</li>
                    <li>We call Settle. You need to make the bet to Settled status.</li>    
                </ul>
            </div>
            
            <div class="product-specific-rules">
                <p> When we resettle the bet:</p>
                <ul>
                    <li>The bet should be in settled status at first.</li>  
                    <li>We call Rollback. You need to make the bet back to running status.</li>
                    <li>We call Settle to resettle the bet. You need to make the bet to Settled status.</li>
                </ul>
            </div>

            <p class="note">You have to implement this API to handle our request. Please implement the ResponseBody as the example below.</p>

            <table class="api-table">
                <tr>
                    <th>Name</th>
                    <th>Sample</th>
                </tr>
                <tr>
                    <td>Path</td>
                    <td>{Your domain}/Settle</td>
                </tr>
                <tr>
                    <td>Method</td>
                    <td>POST</td>
                </tr>
                <tr>
                    <td>Header</td>
                    <td>Content-type : application/json; charset=UTF-8</td>
                </tr>
                <tr>
                    <td>RequestBody</td>
                    <td>
                        <pre>
{
    "CompanyKey":"AXzoeJ3YKhBkRZU57SVXOb4qrx1Kmht5lrzzUBrfkxMY7kokwQyE6F3ILPGM",
    "TransactionCode" : "B532770",
    "Username" : "Player01",
    "WinLoss" : 150000
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <td>ResponseBody</td>
                    <td>
                        <pre>
{
    "AccountName": "Player01",
    "Balance": "5100000.00",
    "ErrorCode": 0,
    "ErrorMessage": "No Error"
}
                        </pre>
                    </td>
                </tr>
            </table>
        </section>
        <section>
            <h2>Rollback</h2>
            <p>If any situation force us to rollback the settlement, after we've rollback the bet, we will send this API request to inform you.</p>
            <p>Rollback means the settled bet in a game will go back to running state, and will have to be settled again.</p>
            <p class="note">You have to implement this API to handle our request. Please implement the ResponseBody as the example below.</p>

            <table class="api-table">
                <tr>
                    <th>Name</th>
                    <th>Sample</th>
                </tr>
                <tr>
                    <td>Path</td>
                    <td>{Your domain}/Rollback</td>
                </tr>
                <tr>
                    <td>Method</td>
                    <td>POST</td>
                </tr>
                <tr>
                    <td>Header</td>
                    <td>Content-type : application/json; charset=UTF-8</td>
                </tr>
                <tr>
                    <td>RequestBody</td>
                    <td>
                        <pre>
{
    "CompanyKey":"AXzoeJ3YKhBkRZU57SVXOb4qrx1Kmht5lrzzUBrfkxMY7kokwQyE6F3ILPGM",
    "TransactionCode" : "B532770",
    "Username" : "Player01"
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <td>ResponseBody</td>
                    <td>
                        <pre>
{
    "AccountName":"Player01",
    "Balance":"4950000.00",
    "ErrorCode":0,
    "ErrorMessage":"No Error"
}
                        </pre>
                    </td>
                </tr>
            </table>
        </section>
        <section>
            <h2>Cancel Bet</h2>
            <p>If any situation force us to cancel the bet, after we've canceled the bet, we will send this API request to inform you.</p>
            <p>Cancel means the running or settled bet in a game will be void , and will not be accepted anymore.</p>

            <div class="product-specific-rules">
                <ul>
                    <li>The bet should be in either Running or Settled status at first.</li>
                    <li>We call Cancel. You need to make the bet to Void status.</li>  
                </ul>
            </div>
            <p class="note">You have to implement this API to handle our request. Please implement the ResponseBody as the example below.</p>

            <table class="api-table">
                <tr>
                    <th>Name</th>
                    <th>Sample</th>
                </tr>
                <tr>
                    <td>Path</td>
                    <td>{Your domain}/Cancel</td>
                </tr>
                <tr>
                    <td>Method</td>
                    <td>POST</td>
                </tr>
                <tr>
                    <td>Header</td>
                    <td>Content-type : application/json; charset=UTF-8</td>
                </tr>
                <tr>
                    <td>RequestBody</td>
                    <td>
                        <pre>
{
    "CompanyKey":"AXzoeJ3YKhBkRZU57SVXOb4qrx1Kmht5lrzzUBrfkxMY7kokwQyE6F3ILPGM",
    "TransactionCode" : "B532770",
    "Username" : "Player01"
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <td>ResponseBody</td>
                    <td>
                        <pre>
{
    "AccountName": "Player01",
    "Balance": "5000000.00",
    "ErrorCode": 0,
    "ErrorMessage": "No Error"
}
                        </pre>
                    </td>
                </tr>
            </table>
        </section>
        <section>
            <h2>Get bet status</h2>
            <p>We will use this API request to sync up bet status between us, normally for checking and debugging purpose.</p>
            <p>For example, if a bet in system is settled, but the wallet status in your system is still running, then we can find out the bet has problem.</p>

            <p class="note">You would have to implement the interface to handle our request. Please implement the ResponseBody as the example below.</p>

            <table class="api-table">
                <tr>
                    <th>Name</th>
                    <th>Sample</th>
                </tr>
                <tr>
                    <td>Path</td>
                    <td>{Your domain}/GetBetStatus</td>
                </tr>
                <tr>
                    <td>Method</td>
                    <td>POST</td>
                </tr>
                <tr>
                    <td>Header</td>
                    <td>Content-type : application/json; charset=UTF-8</td>
                </tr>
                <tr>
                    <td>RequestBody</td>
                    <td>
                        <pre>
{
    "CompanyKey":"AXzoeJ3YKhBkRZU57SVXOb4qrx1Kmht5lrzzUBrfkxMY7kokwQyE6F3ILPGM",
    "TransactionCode" : "B532770",
    "Username" : "Player01"
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <td>ResponseBody</td>
                    <td>
                        <pre>
{
    "TransactionCode":"B532770",
    "Status":"settled",
    "ErrorCode":0,
    "ErrorMessage":"No Error"
}
                        </pre>
                    </td>
                </tr>
            </table>
        </section>
        <section>
            <h2>Remark</h2>
            <table class="api-table">
                <tr>
                    <th>Request Field Name</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>Username (Post)</td>
                    <td>string</td>
                    <td>Username cannot be longer than 20 chars. Only numeric, alphabet and _ is allowed in Username. Username must be unique among all users in fund provider.</td>    
                </tr>
                <tr>
                    <td>GameId</td>
                    <td>int</td>
                    <td>The GameId of the game. Please check the <a href="#game-list">Game List</a> below.</td>    
                </tr>
                <tr>
                    <td>AccountName (Call Back)</td>
                    <td>string</td>
                    <td>Username cannot be longer than 20 chars. Only numeric, alphabet and _ is allowed in Username. Username must be unique among all users in fund provider.</td>
                </tr>
                <tr>
                    <td>Amount (Post)</td>
                    <td>decimal</td>
                    <td>Amount of bet.</td>
                </tr>
                <tr>
                    <td>BetAmount (Call Back)</td>
                    <td>decimal</td>
                    <td>Amount of bet.</td>
                </tr>
                <tr>
                    <td>TransactionCode</td>
                    <td>string</td>
                    <td>Everytime when a member place a bet, it generates a unique transaction code refering to the bet, so each bet has their own transaction code.</td>
                </tr>
                <tr>
                    <td>Balance</td>
                    <td>decimal</td>
                    <td>Member's account balance.(If errorCode is not 0 , balance should be 0 )</td>
                </tr>
                <tr>
                    <td>ErrorCode</td>
                    <td>int</td>
                    <td>Please check the <a href="#error-list">Error list</a> below.</td>
                </tr>
                <tr>
                    <td>ErrorMessage</td>
                    <td>string</td>
                    <td>Please check the <a href="#error-list">Error list</a> below.</td>
                </tr>
                
                
            </table>
        </section>
        <section id="error-list">
            <h2>Error List</h2>
            <table class="api-table">
                <tr>
                    <th>Error Code</th>
                    <th>Error Message</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>No Error</td>
                    <td>The request has been correctly response</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Member not exist</td>
                    <td>The member is not exist</td>
                </tr>
                {{-- <tr>
                    <td>2</td>
                    <td>Invalid Ip</td>
                    <td>The IP is invalid</td>
                </tr> --}}
                <tr>
                    <td>3</td>
                    <td>Username empty</td>
                    <td>Username is empty</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Invalid CompanyKey</td>
                    <td>The CompanyKey is error</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Not enough balance</td>
                    <td>Member's balance is not enough</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Bet not exists</td>
                    <td>Return this error code will stop the resend any request from L21game.</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Internal Error</td>
                    <td>*</td>
                </tr>
                <tr>
                    <td>2001
                    <td>Bet Already Settled</td>
                    <td>Return this error code will stop the resend settle request from L21game.</td>
                </tr>
                <tr>
                    <td>2002</td>
                    <td>Bet Already Canceled</td>
                    <td>Return this error code will stop the resend cancel request from L21game.</td>
                </tr>
                <tr>
                    <td>2003</td>
                    <td>Bet Already Rollback</td>
                    <td>Return this error code will stop the resend rollback request from L21game.</td>
                </tr>
                <tr>
                    <td>5003</td>
                    <td>Bet With Same RefNo Exists</td>
                    <td>Bet with same refNo already exists.</td>
                </tr>
                {{-- <tr>
                    <td>5008</td>
                    <td>Bet Already Returned Stake</td>
                    <td>Bet already returned stake.</td>
                </tr> --}}
            </table>
        </section>
        <section id="game-list">
            <h2>Game List</h2>
            <table class="api-table">
                <tr>
                    <th>Game Id</th>
                    <th>Game Name</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Bak Buk</td>
                 </tr>
            </table>
        </section>
    </div>
</body>
</html>