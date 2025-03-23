import React, { useContext, useEffect, useState } from 'react'
import './index.css'
import UserInput from '../../components/UserInput'
import { AppContext } from '../../contexts/AppContext'
const Login = () => {

    const { login, navigate, HomeRedirectIfNeeded, syncToken, token } = useContext(AppContext)
    useEffect(() => {
        syncToken()
    }, [])
    useEffect(() => {
        HomeRedirectIfNeeded()
    }, [token])



    const [inputUsername, setInputUsername] = useState("")
    const [inputPassword, setInputPassword] = useState("")
    const submit = async () => {
        await login(inputUsername, inputPassword)
    }
    const navigateToSignup = () => {
        navigate("/signup")
    }
    return (
        <div className='center page'>
            <div className='flex-column'>
                <UserInput inputName='username' setState={setInputUsername} />
                <UserInput inputName='password' setState={setInputPassword} inputType='password' />
                <button className='marign' onClick={submit}>submit</button>
                <p>don't have an account yet? <span className='signup' onClick={navigateToSignup}>Signup</span></p>
            </div>
        </div>
    )
}

export default Login