@extends('index')
@section('container')

<style>
 /* :root {
    --green-color: #65E080;
    --red-color: #F34040;
    --yellow-color: #F3D040;
    --purple-color: #D356FF;
 }; */

.secdashboard {
  width: 100%;
  display: grid;
  grid-template-columns: 3fr 1fr;
  gap: 15px;
  padding: 10px 20px 120px 20px;
}

.ccgrouplistsecdashboard {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.grouplistsecdashboard {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
}

.listsecdashboard {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.listsecdashboard a {
  width: 100%;
}

.groupdatalistdashboard {
  width: 100%;
  min-height: 110px;
  padding: 10px;
  background: var(--bg-box-primary);
  border-radius: 6px;
  display: flex;
  justify-content: space-between;
  border: 1px solid rgba(var(--rgba-primary), 0.1);
  transition: all 0.3s ease;
}

.groupdatalistdashboard:hover {
  border: 1px solid rgba(var(--rgba-primary), 0.5);
}

.groupdatalistdashboard svg {
  width: 30px;
  height: 30px;
  color: white;
  stroke: unset;
}

.listdatagroupls {
  width: 100%;
  display: flex;
  flex-direction: column;
}

.countdata {
  color: rgba(var(--rgba-white), 0.9);
  font-family: 'myFont1';
  font-size: 50px;
}

.deposit svg,
.deposit .countdata,
.deposit .countdetail {
  stroke: unset;
  color: var(--green-color);
}

.withdraw svg,
.withdraw .countdata,
.withdraw .countdetail {
  stroke: unset;
  color: var(--red-color);
}

.textdetail {
  text-transform: capitalize;
}

.groupdatalistdashboard .chart-custom {
  width: 50px;
  height: 50px;
}

.listdatagrouplsmid {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  gap: 5px;
}

.listdatagrouplsmid .detailtitle {
  font-family: 'myFont1';
  text-transform: uppercase;
  color: rgba(var(--rgba-white), 0.9);
}

.listdatagrouplsmid .countdetail {
  font-family: 'myFont1';
  font-size: 25px;
}

.listsecdashboard.group {
  width: 100%;
  padding: 20px;
  background: var(--bg-box-primary);
  border-radius: 6px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 30px;
  border: 1px solid rgba(var(--rgba-primary), 0.1);
  transition: all 0.3s ease;
}

.listsecdashboard.group .groupdatalistdashboard {
  width: 100%;
  background: rgba(var(--rgba-primary-bg-color));
  box-shadow: var(--shadow-shoft);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 10px;
  position: relative;
}

.listsecdashboard.group .countdata {
  font-size: 30px;
}

.listsecdashboard.group svg {
  width: 25px;
  height: 25px;
  color: var(--green-color);
  stroke: unset;
  position: absolute;
  top: 15px;
  right: 15px;
}

.titlegrp {
  color: rgba(var(--rgba-white), 0.9);
  font-family: 'myFont1';
  text-transform: uppercase;
  font-size: 20px;
}

.groupboxlist {
  width: 100%;
  display: flex;
  justify-content: space-between;
}


.groupstatusagent {
  width: 100%;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 15px;
}

.groupstatusagent .listdatagrouplsmid {
  width: 100%;
  min-height: 70px;
  padding: 10px;
  background: var(--bg-box-primary);
  border-radius: 6px;
  display: flex;
  justify-content: space-between;
  border: 1px solid rgba(var(--rgba-primary), 0.1);
  transition: all 0.3s ease;
}

.groupstatusagent .listdatagrouplsmid:hover {
  border: 1px solid rgba(var(--rgba-primary), 0.5);
}

.groupstatusagent .listdatagrouplsmid .detailtitle {
  font-size: 13px;
}

.groupstatusagent .listdatagrouplsmid .countdetail {
  font-size: 20px;
  color: var(--green-color);
}

</style>

<div class="secdashboard">
    <div class="ccgrouplistsecdashboard">
        <div class="groupstatusagent">
            <div class="listdatagrouplsmid">
                <span class="detailtitle">currency </span>
                <span class="countdetail">IDR</span>
            </div>
            <div class="listdatagrouplsmid">
                <span class="detailtitle">cash balanse </span>
                <span class="countdetail nominal" data-value="0">IDR 0</span>
            </div>
            <div class="listdatagrouplsmid">
                <span class="detailtitle">member balance </span>
                <span class="countdetail nominal" data-value="0">IDR 0</span>
            </div>
            <div class="listdatagrouplsmid">
                <span class="detailtitle">total balance </span>
                <span class="countdetail nominal" data-value="0">IDR 0</span>
            </div>
        </div>
        <div class="grouplistsecdashboard">
            <div class="listsecdashboard">
                <div class="groupdatalistdashboard deposit">
                    <div class="listdatagroupls">
                        <span class="countdata">0</span>
                        <span class="textdetail">total deposit accepted 15 April 2024</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M95.5 104h320a87.73 87.73 0 0 1 11.18.71a66 66 0 0 0-77.51-55.56L86 94.08h-.3a66 66 0 0 0-41.07 26.13A87.57 87.57 0 0 1 95.5 104m320 24h-320a64.07 64.07 0 0 0-64 64v192a64.07 64.07 0 0 0 64 64h320a64.07 64.07 0 0 0 64-64V192a64.07 64.07 0 0 0-64-64M368 320a32 32 0 1 1 32-32a32 32 0 0 1-32 32"></path>
                        <path fill="currentColor" d="M32 259.5V160c0-21.67 12-58 53.65-65.87C121 87.5 156 87.5 156 87.5s23 16 4 16s-18.5 24.5 0 24.5s0 23.5 0 23.5L85.5 236Z"></path>
                    </svg>
                </div>
                <div class="groupdatalistdashboard deposit">
                    <div class="listdatagroupls">
                        <span class="countdata nominal" data-value="0">IDR 0</span>
                        <span class="textdetail">Jumlah coin Deposit accepted 15 April 2024</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="chart-custom">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5L9 10l4 6l8-9.5"></path>
                    </svg>
                </div>
                <div class="groupdatalistdashboard deposit">
                    <div class="listdatagrouplsmid">
                        <span class="detailtitle">real deposit </span>
                        <span class="countdetail nominal" data-value="0">IDR 0</span>
                    </div>
                    <div class="listdatagrouplsmid">
                        <span class="detailtitle">deposit manual</span>
                        <span class="countdetail nominal" data-value="0">IDR 0</span>
                    </div>
                </div>
                <div class="groupdatalistdashboard">
                    <div class="listdatagroupls">
                        <span class="countdata">0</span>
                        <span class="textdetail">total request form deposit 15 April 2024</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4.115 11q-.666 0-1.14-.475q-.475-.474-.475-1.14v-3.27q0-.666.475-1.14q.474-.475 1.14-.475H13V11zm0-1H12V5.5H4.115q-.269 0-.442.173t-.173.442v3.27q0 .269.173.442t.442.173m0 9.5q-.666 0-1.14-.475q-.475-.474-.475-1.14v-3.27q0-.666.475-1.14Q3.449 13 4.115 13H15v6.5zm0-1H14V14H4.115q-.269 0-.442.173t-.173.442v3.27q0 .269.173.442t.442.173M17 19.5V11h-2V4.5h6.27l-2 5.115h1.96zM5 17h1.5v-1.5H5zm0-8.5h1.5V7H5zM3.5 10V5.5zm0 8.5V14z"></path>
                    </svg>
                </div>
                <div class="groupdatalistdashboard bet">
                    <div class="listdatagroupls">
                        <span class="countdata">0</span>
                        <span class="textdetail">total user bets settled 15 April 2024</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 36 36">
                        <circle cx="17.99" cy="10.36" r="6.81" fill="currentColor" class="clr-i-solid clr-i-solid-path-1"></circle>
                        <path fill="currentColor" d="M12 26.65a2.8 2.8 0 0 1 4.85-1.8L20.71 29l6.84-7.63A16.81 16.81 0 0 0 18 18.55A16.13 16.13 0 0 0 5.5 24a1 1 0 0 0-.2.61V30a2 2 0 0 0 1.94 2h8.57l-3.07-3.3a2.81 2.81 0 0 1-.74-2.05" class="clr-i-solid clr-i-solid-path-2"></path>
                        <path fill="currentColor" d="M28.76 32a2 2 0 0 0 1.94-2v-3.76L25.57 32Z" class="clr-i-solid clr-i-solid-path-3"></path>
                        <path fill="currentColor" d="M33.77 18.62a1 1 0 0 0-1.42.08l-11.62 13l-5.2-5.59a1 1 0 0 0-1.41-.11a1 1 0 0 0 0 1.42l6.68 7.2L33.84 20a1 1 0 0 0-.07-1.38" class="clr-i-solid clr-i-solid-path-4"></path>
                        <path fill="none" d="M0 0h36v36H0z"></path>
                    </svg>
                </div>
            </div>
            <div class="listsecdashboard">
                <div class="groupdatalistdashboard withdraw">
                    <div class="listdatagroupls">
                        <span class="countdata">0</span>
                        <span class="textdetail">total withdraw accepted 15 April 2024</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M16 12c2.76 0 5-2.24 5-5s-2.24-5-5-5s-5 2.24-5 5s2.24 5 5 5m5.45 5.6c-.39-.4-.88-.6-1.45-.6h-7l-2.08-.73l.33-.94L13 16h2.8c.35 0 .63-.14.86-.37s.34-.51.34-.82c0-.54-.26-.91-.78-1.12L8.95 11H7v9l7 2l8.03-3c.01-.53-.19-1-.58-1.4M5 11H.984v11H5z"></path>
                    </svg>
                </div>
                <div class="groupdatalistdashboard withdraw">
                    <div class="listdatagroupls">
                        <span class="countdata nominal" data-value="0">IDR 0</span>
                        <span class="textdetail">Jumlah coin withdraw accepted 15 April 2024</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="chart-custom">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5L9 10l4 6l8-9.5"></path>
                    </svg>
                </div>
                <div class="groupdatalistdashboard withdraw">
                    <div class="listdatagrouplsmid">
                        <span class="detailtitle">real withdraw</span>
                        <span class="countdetail nominal" data-value="0">IDR 0</span>
                    </div>
                    <div class="listdatagrouplsmid">
                        <span class="detailtitle">withdraw manual</span>
                        <span class="countdetail nominal" data-value="0">IDR 0</span>
                    </div>
                </div>
                <div class="groupdatalistdashboard">
                    <div class="listdatagroupls">
                        <span class="countdata">0</span>
                        <span class="textdetail">total request form withdraw 15 April 2024</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4.115 11q-.666 0-1.14-.475q-.475-.474-.475-1.14v-3.27q0-.666.475-1.14q.474-.475 1.14-.475H13V11zm0-1H12V5.5H4.115q-.269 0-.442.173t-.173.442v3.27q0 .269.173.442t.442.173m0 9.5q-.666 0-1.14-.475q-.475-.474-.475-1.14v-3.27q0-.666.475-1.14Q3.449 13 4.115 13H15v6.5zm0-1H14V14H4.115q-.269 0-.442.173t-.173.442v3.27q0 .269.173.442t.442.173M17 19.5V11h-2V4.5h6.27l-2 5.115h1.96zM5 17h1.5v-1.5H5zm0-8.5h1.5V7H5zM3.5 10V5.5zm0 8.5V14z"></path>
                    </svg>
                </div>
                <div class="groupdatalistdashboard bet">
                    <div class="listdatagroupls">
                        <span class="countdata nominal" data-value="0">IDR 0</span>
                        <span class="textdetail">total Coin bets settled 15 April 2024</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd" d="M7.099 1.25H16.9c1.017 0 1.717 0 2.306.204a3.796 3.796 0 0 1 2.348 2.412l-.713.234l.713-.234c.196.597.195 1.307.195 2.36v14.148c0 1.466-1.727 2.338-2.864 1.297a.196.196 0 0 0-.271 0l-.484.442c-.928.85-2.334.85-3.262 0a.907.907 0 0 0-1.238 0c-.928.85-2.334.85-3.262 0a.907.907 0 0 0-1.238 0c-.928.85-2.334.85-3.262 0l-.483-.442a.196.196 0 0 0-.272 0c-1.137 1.04-2.864.169-2.864-1.297V6.227c0-1.054 0-1.764.195-2.361a3.795 3.795 0 0 1 2.348-2.412c.59-.205 1.289-.204 2.306-.204m.146 1.5c-1.221 0-1.642.01-1.96.121A2.296 2.296 0 0 0 3.87 4.334c-.111.338-.12.784-.12 2.036v14.004c0 .12.059.192.134.227a.2.2 0 0 0 .11.018a.194.194 0 0 0 .107-.055a1.695 1.695 0 0 1 2.296 0l.483.442a.907.907 0 0 0 1.238 0a2.407 2.407 0 0 1 3.262 0a.907.907 0 0 0 1.238 0a2.407 2.407 0 0 1 3.262 0a.907.907 0 0 0 1.238 0l.483-.442a1.695 1.695 0 0 1 2.296 0c.043.04.08.052.108.055a.2.2 0 0 0 .109-.018c.075-.035.135-.108.135-.227V6.37c0-1.252-.01-1.698-.12-2.037a2.296 2.296 0 0 0-1.416-1.462c-.317-.11-.738-.12-1.959-.12zM6.25 7.5A.75.75 0 0 1 7 6.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75M6.25 11a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75m-3.5 3.5a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="listsecdashboard group">
        <div class="groupdatalistdashboard">
            <span class="titlegrp">member online</span>
            <div class="groupboxlist">
                <div class="listdatagroupls">
                    <span class="countdata">0</span>
                    <span class="textdetail">total member online 15 April 2024</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M14 19.5c0-2 1.1-3.8 2.7-4.7c-1.3-.5-2.9-.8-4.7-.8c-4.4 0-8 1.8-8 4v2h10zm5.5-3.5c-1.9 0-3.5 1.6-3.5 3.5s1.6 3.5 3.5 3.5s3.5-1.6 3.5-3.5s-1.6-3.5-3.5-3.5M16 8c0 2.2-1.8 4-4 4s-4-1.8-4-4s1.8-4 4-4s4 1.8 4 4"></path>
                </svg>
            </div>
        </div>
        <div class="groupdatalistdashboard">
            <span class="titlegrp">new member regist</span>
            <div class="groupboxlist">
                <div class="listdatagroupls">
                    <span class="countdata">0</span>
                    <span class="textdetail">pemain yang sudah daftar 15 April 2024</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 17v2H7v-2s0-4 6-4s6 4 6 4m-3-9a3 3 0 1 0-3 3a3 3 0 0 0 3-3m3.2 5.06A5.6 5.6 0 0 1 21 17v2h3v-2s0-3.45-4.8-3.94M18 5a2.9 2.9 0 0 0-.89.14a5 5 0 0 1 0 5.72A2.9 2.9 0 0 0 18 11a3 3 0 0 0 0-6M8 10H5V7H3v3H0v2h3v3h2v-3h3Z"></path>
                </svg>
            </div>
        </div>
        <div class="groupdatalistdashboard">
            <span class="titlegrp">new member deposit</span>
            <div class="groupboxlist">
                <div class="listdatagroupls">
                    <span class="countdata">0</span>
                    <span class="textdetail">pemain baru yang sudah deposit 15 April 2024</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 17v2H7v-2s0-4 6-4s6 4 6 4m-3-9a3 3 0 1 0-3 3a3 3 0 0 0 3-3m3.2 5.06A5.6 5.6 0 0 1 21 17v2h3v-2s0-3.45-4.8-3.94M18 5a2.9 2.9 0 0 0-.89.14a5 5 0 0 1 0 5.72A2.9 2.9 0 0 0 18 11a3 3 0 0 0 0-6M7.34 8.92l1.16 1.41l-4.75 4.75l-2.75-3l1.16-1.16l1.59 1.58z"></path>
                </svg>
            </div>
        </div>
        <div class="groupdatalistdashboard">
            <span class="titlegrp">total member</span>
            <div class="groupboxlist">
                <div class="listdatagroupls">
                    <span class="countdata">0</span>
                    <span class="textdetail">total keseluruhan member 15 April 2024</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 5.5A3.5 3.5 0 0 1 15.5 9a3.5 3.5 0 0 1-3.5 3.5A3.5 3.5 0 0 1 8.5 9A3.5 3.5 0 0 1 12 5.5M5 8c.56 0 1.08.15 1.53.42c-.15 1.43.27 2.85 1.13 3.96C7.16 13.34 6.16 14 5 14a3 3 0 0 1-3-3a3 3 0 0 1 3-3m14 0a3 3 0 0 1 3 3a3 3 0 0 1-3 3c-1.16 0-2.16-.66-2.66-1.62a5.54 5.54 0 0 0 1.13-3.96c.45-.27.97-.42 1.53-.42M5.5 18.25c0-2.07 2.91-3.75 6.5-3.75s6.5 1.68 6.5 3.75V20h-13zM0 20v-1.5c0-1.39 1.89-2.56 4.45-2.9c-.59.68-.95 1.62-.95 2.65V20zm24 0h-3.5v-1.75c0-1.03-.36-1.97-.95-2.65c2.56.34 4.45 1.51 4.45 2.9z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection
