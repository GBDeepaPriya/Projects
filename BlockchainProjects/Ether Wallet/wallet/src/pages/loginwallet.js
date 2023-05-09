import React from 'react'
import "./pages.css"
import {ethers} from 'ethers'
import { useNavigate } from 'react-router-dom'


let k1;
let k2;
let k3;
let k4;
let k5;
let k6;
let k7;
let k8;
let k9;
let k10;
let k11;
let k12;

export default function LoginWallet() {
    let navigate = useNavigate();
    const create = () => {
        k1 = document.getElementById("1").value;
        k2 = document.getElementById("2").value;
        k3 = document.getElementById("3").value;
        k4 = document.getElementById("4").value;
        k5 = document.getElementById("5").value;
        k6 = document.getElementById("6").value;
        k7 = document.getElementById("7").value;
        k8 = document.getElementById("8").value;
        k9 = document.getElementById("9").value;
        k10 = document.getElementById("10").value;
        k11 = document.getElementById("11").value;
        k12 = document.getElementById("12").value;

        let wordlists = `${k1} ${k2} ${k3} ${k4} ${k5} ${k6} ${k7} ${k8} ${k9} ${k10} ${k11} ${k12}`
        let userWallet = ethers.Wallet.fromMnemonic(wordlists)       
        console.log(wordlists);
        localStorage.setItem("pkey",userWallet.privateKey)
        navigate("/home")
   }
  return (
    <div className = 'flex flex-col min-h-screen'>
       <main className='container mx-auto w-screen lg:max-w-screen-lg flex-1'>
            <div className='shadow-md shadow-slate-200 content-center flex-row items-center justify-center'>
                <div>
                    <div className= 'my-17 flex py-2 px-4'>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="1"  value={k1} className="inputfields placeholder-gray-700" placeholder='1' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="2"  value={k2} className="inputfields placeholder-gray-700"  placeholder='2' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="3"  value={k3} className="inputfields placeholder-gray-700"  placeholder='3' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="4" value={k4} className="inputfields placeholder-gray-700"  placeholder='4' type={"text"}/>
                        </div>
                    </div>
                    <div className= 'my-17 flex py-2 px-4'>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="5" value={k5} className="inputfields placeholder-gray-700"  placeholder='5' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="6" value={k6} className="inputfields placeholder-gray-700"  placeholder='6' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="7"  value={k7} className="inputfields placeholder-gray-700" placeholder='7' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="8"  value={k8} className="inputfields placeholder-gray-700"  placeholder='8' type={"text"}/>
                        </div>

                    </div>
                    <div className= 'my-17 flex py-2 px-4'>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="9"  value={k9} className="inputfields placeholder-gray-700"  placeholder='9' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="10"  value={k10} className="inputfields placeholder-gray-700"  placeholder='10' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="11"  value={k11} className="inputfields placeholder-gray-700"  placeholder='11' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="12"  value={k12} className="inputfields placeholder-gray-700"  placeholder='12' type={"text"}/>
                        </div>
                    
                    </div> 
                    <div className= 'content-center align-middle justify-center flex p-4'>
                    <button onClick={create} className='text-center text-indigo-400 font-bold rounded py-2 w-2/12 focus:outline-none bg-gray-900 border-2 border-indigo-400'>
                      Create Wallet
                    </button> 
                    </div>     
                </div>
            </div>
       </main>
    
    </div>
  )
}