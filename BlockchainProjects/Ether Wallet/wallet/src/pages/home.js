import React from 'react'
import { useNavigate } from "react-router-dom";
import { ethers } from 'ethers'

export default function Home() {
    const provider = new ethers.providers.JsonRpcProvider("https://sepolia.infura.io/v3/9aa3d95b3bc440fa88ea12eaa4456161");
    //const signer = provider.getSigner()
    const userWallet = new ethers.Wallet(localStorage.getItem("pkey"), provider)

    provider.getBalance(userWallet.address).then((balance) => {
        const balanceInEth = ethers.utils.formatEther(balance)
        document.getElementById("bal").innerHTML = balanceInEth
    })

    let navigate = useNavigate();

    let routotosendth = () => {
        navigate("/send")
    }

    return ( <
        div className = 'flex flex-col min-h-screen' >
        <
        main className = 'container mx-auto w-screen lg:max-w-screen-lg flex-1' >
        <
        div className = 'shadow-md shadow-slate-200 content-center flex-row items-center justify-center' >
        <
        div className = 'text-center p-4' >
        <
        p className = 'font-bold' > < button href = '#'
        id = 'adrs'
        onClick = { navigator.clipboard.writeText(userWallet.address) } > { userWallet.address } < /button></p >
        <
        /div> <
        div className = 'test-center p-4' >
        <
        p id = 'bal'
        className = 'font-bold text-4x1' / >
        <
        /div> <
        div className = 'justify-center align-middle flex content-center' >
        <
        button onClick = { routotosendth }
        className = 'text-center text-indigo-400 font-bold rounded py-2 w-2/12 focus:outline-none bg-gray-900 border-2 border-indigo-400' > Send Ether < /button> <
        /div> <
        /div> <
        /main>

        <
        /div>
    )
}