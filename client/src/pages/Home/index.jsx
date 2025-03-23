import React, { useContext, useEffect } from 'react'
import './index.css'
import { AppContext } from '../../contexts/AppContext'
import ProfileMenu from '../../components/ProfileMenu'

const Home = () => {

  const {
    loginRedirectIfNeeded,
    syncToken,
    token
  } = useContext(AppContext)


  useEffect(() => {
    syncToken()
  }, [])
  
  useEffect(() => {
    loginRedirectIfNeeded()
  }, [token])


  return (
    <div><ProfileMenu />Home</div>

  )
}

export default Home