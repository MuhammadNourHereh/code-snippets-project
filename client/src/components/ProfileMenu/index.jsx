import React, { useContext } from 'react'
import './index.css'
import { AppContext } from '../../contexts/AppContext'

const ProfileMenu = () => {

  const {
    logout,
  } = useContext(AppContext)


  return (
    <div>
      <button>profile</button>
      <button onClick={logout}>logout</button>
    </div>
  )
}

export default ProfileMenu