import React, { useContext, useEffect, useState } from 'react'
import './index.css'
import UserInput from '../../components/UserInput'
import { AppContext } from '../../contexts/AppContext'

const Signup = () => {

  const { navigate, HomeRedirectIfNeeded, token, syncToken } = useContext(AppContext)

  useEffect(() => {
    syncToken()
  }, [])
  useEffect(() => {
    HomeRedirectIfNeeded()
  }, [token])


  const navigateToLogin = () => {
    navigate('/login')
  }

  const [username, setUsername] = useState("")
  const [password, setPassword] = useState("")
  const [repassword, setRepassword] = useState("")
  const [firstname, setFirstname] = useState("")
  const [lastname, setLastname] = useState("")

  const signup = async () => {
    if (password !== repassword) {
      console.log("repassword and password don't match")
      return
    }

    const res = await remote.signup(username, firstname, lastname, password)
    navigate("/login")
  }

  return (
    <div className='center page'>
      <div
        className='flex-column'>
        <UserInput inputName='username' setState={setUsername} />
        <UserInput inputName='firstname' setState={setFirstname} />
        <UserInput inputName='lastname' setState={setLastname} />
        <UserInput inputName='password' setState={setPassword} inputType='password' />
        <UserInput inputName='re-password' setState={setRepassword} inputType='password' />
        <button className='marign' onClick={signup}>signup</button>
        <p>already have an account? <span className='login' onClick={navigateToLogin}>login</span></p>
      </div>
    </div>
  )
}

export default Signup