import React from 'react'
import './index.css'
import SearchBar from '../SearchBar'
import ProfileIcon from '../ProfileIcon'
import Logo from '../Logo'

const Nav = () => {
  return (
    <nav>
      <Logo />
      <SearchBar />
      <ProfileIcon />
    </nav>
  )
}

export default Nav