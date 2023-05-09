import React from 'react'
import "./pages.css"
import {Wallet,ethers} from 'ethers'
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

export default function Createwallet() {
    const userWalletKeys = Wallet.createRandom().mnemonic
    const userWallet = ethers.Wallet.fromMnemonic(userWalletKeys.phrase)
    
    const words=userWalletKeys.phrase.split(' ')
    let navigate = useNavigate();
    //set words
    k1 = `1: ${words[0]}`;
    k2 = `2: ${words[1]}`;
    k3 = `3: ${words[2]}`;
    k4 = `4: ${words[3]}`;
    k5 = `5: ${words[4]}`;
    k6 = `6: ${words[5]}`;
    k7 = `7: ${words[6]}`;
    k8 = `8: ${words[7]}`;
    k9 = `9: ${words[8]}`;
    k10 =`10: ${words[9]}`;
    k11 = `11: ${words[10]}`;
    k12 = `12: ${words[11]}`;

    const copykeys = () => {
        navigator.clipboard.writeText(userWalletKeys.phrase)
    }
    const create = () => {
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
                            <input id="1" onCopy ={copykeys} value={k1} className="inputfields placeholder-gray-700" disabled placeholder='1' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="2" onCopy ={copykeys} value={k2} className="inputfields placeholder-gray-700" disabled placeholder='2' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="3" onCopy ={copykeys} value={k3} className="inputfields placeholder-gray-700" disabled placeholder='3' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="4" onCopy ={copykeys} value={k4} className="inputfields placeholder-gray-700" disabled placeholder='4' type={"text"}/>
                        </div>
                    </div>
                    <div className= 'my-17 flex py-2 px-4'>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="5" onCopy ={copykeys} value={k5} className="inputfields placeholder-gray-700" disabled placeholder='5' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="6" onCopy ={copykeys} value={k6} className="inputfields placeholder-gray-700" disabled placeholder='6' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="7" onCopy ={copykeys} value={k7} className="inputfields placeholder-gray-700" disabled placeholder='7' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="8" onCopy ={copykeys} value={k8} className="inputfields placeholder-gray-700" disabled placeholder='8' type={"text"}/>
                        </div>

                    </div>
                    <div className= 'my-17 flex py-2 px-4'>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="9" onCopy ={copykeys} value={k9} className="inputfields placeholder-gray-700" disabled placeholder='9' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="10" onCopy ={copykeys} value={k10} className="inputfields placeholder-gray-700" disabled placeholder='10' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="11" onCopy ={copykeys} value={k11} className="inputfields placeholder-gray-700" disabled placeholder='11' type={"text"}/>
                        </div>
                        <div className='flex-row flex-center lg:flex items-center flex-center p-2'>
                            <input id="12" onCopy ={copykeys} value={k12} className="inputfields placeholder-gray-700" disabled placeholder='12' type={"text"}/>
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