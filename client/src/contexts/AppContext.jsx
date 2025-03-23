import { createContext, useEffect, useState } from "react"
import { useNavigate } from "react-router-dom"
import remote from '../utils/remote/requests'

// Create Context with Default Value
export const AppContext = createContext(null)

export function AppProvider({ children }) {
    // Navigation
    const navigate = useNavigate()

    // User States
    const [firstName, setFirstName] = useState("")
    const [lastName, setLastName] = useState("")
    const [username, setUserName] = useState("")
    const [token, setToken] = useState("")

    const login = async (inputUsername, inputPassword) => {
        const res = await remote.login(inputUsername, inputPassword)
        localStorage.setItem("user", JSON.stringify(res.user))
        syncToken()
        navigate("/home")
    }
    const logout = async () => {
        const res = await remote.logout(token)
        console.log(res)
        localStorage.removeItem("user")
        syncToken()
        navigate("/login")
    }

    const loginRedirectIfNeeded = () => {
        if (token === "") {
            navigate("/login")
        }
    }
    const HomeRedirectIfNeeded = () => {
        if (token !== "") {
            navigate("/home")
        }
    }

    const syncToken = () => {
        const user = localStorage.getItem("user");

        if (user) {
            const parsedUser = JSON.parse(user); // Correctly parse JSON
            setFirstName(parsedUser.firstname || '');
            setLastName(parsedUser.lastname || '');
            setUserName(parsedUser.username || '');
            setToken(parsedUser.token || '');
        } else {
            setFirstName('');
            setLastName('');
            setUserName('');
            setToken('');
        }
    };

    return (
        <AppContext.Provider value={{
            navigate,
            firstName, setFirstName,
            lastName, setLastName,
            username, setUserName,
            token,
            syncToken,
            login, logout,
            loginRedirectIfNeeded,
            HomeRedirectIfNeeded
        }}>
            {children}
        </AppContext.Provider>
    )
}