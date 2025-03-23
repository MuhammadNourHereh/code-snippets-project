import React, { useContext } from 'react'
import './index.css'
import { AppContext } from '../../contexts/AppContext'

const Profile = () => {

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
    <div>Profile</div>
  )
}

export default Profile