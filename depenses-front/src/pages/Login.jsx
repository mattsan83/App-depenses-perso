import { useState } from "react";
import apiClient from "../api/axios";
import { useNavigate } from "react-router-dom";


const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const navigate = useNavigate();

    const handleSubmit = async (e) => { 
        e.preventDefault(); 
        try { 
            const response = await apiClient.post("/login", { 
                email, 
                password, 
            }); 
            const token = response.data.token; 
            localStorage.setItem("token", token); 
            apiClient.defaults.headers.common.Authorization = `Bearer ${token}`;
            navigate("/dashboard");
        } 
        catch (err) { 
            setError("Invalid email or password"); 
        } 
    };


    return (
        <div>
            <h1>Login</h1>
            <form onSubmit={handleSubmit}>
                <div>
                    <label>Email:</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                    />
                </div>
                <div>
                    <label>Password:</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                </div>
                <button type="submit">Login</button>
            </form>
            {error && <p>{error}</p>}
        </div>
    );
};


    


export default Login;