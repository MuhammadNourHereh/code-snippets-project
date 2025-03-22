import { createContext, useEffect, useState } from "react"
import { useNavigate } from "react-router-dom"

// Create Context with Default Value
export const AppContext = createContext(null)

export function AppProvider({ children }) {
    // Navigation
    const navigate = useNavigate()

    // User States
    const [firstName, setFirstName] = useState("")
    const [lastName, setLastName] = useState("")
    const [username, setUserName] = useState("")


    const login = () => {
        const user = localStorage.getItem("user")
        const parsedUser = JSON.parse(user)
        setFirstName(parsedUser.first_name)
        setLastName(parsedUser.last_name)
        setUserName(parsedUser.username)

    }
    const logout = () => {
        console.log("logout")
        localStorage.removeItem("user")
        navigate("/login");
    }

    const loginRedirectIfNeeded = () => {
        if (username === "") {
            navigate("/login")
        }
    }

    return (
        <AppContext.Provider value={{
            navigate,
            firstName, setFirstName,
            lastName, setLastName,
            username, setUserName,
            login, logout,
            loginRedirectIfNeeded
        }}>
            {children}
        </AppContext.Provider>
    )
}