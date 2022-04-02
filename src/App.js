import React from "react";
import { useState } from "react";
import "./App.css";
import axios from "axios";

function App() {
  const [state, setState] = useState({
    fname: "",
    email: "",
    message: "",
    mailSent: false,
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setState((prev) => ({
      ...prev,
      [name]: value,
    }));
  };
  const handleSubmit = (e) => {
    e.preventDefault();
    console.log(state);

    axios
      .post("http://localhost:3001/api/", state)
      .then((res) => {
        setState((prev) => ({ ...prev, mailSent: res.data.sent }));
      })
      .catch((err) => {
        console.error(err);
      });
  };

  return (
    <div className="App">
      <h1>Contact Me</h1>
      <div className="form">
        <form>
          <label>First Name</label>
          <input
            type="text"
            id="fname"
            name="fname"
            placeholder="Your name.."
            className="form-control"
            onChange={(e) => {
              handleChange(e);
            }}
          />
          <label>Email</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Your email"
            className="form-control"
            onChange={(e) => {
              handleChange(e);
            }}
          />

          <label>Message</label>
          <textarea
            id="message"
            name="message"
            placeholder="Write something..."
            className="form-control"
            onChange={(e) => {
              handleChange(e);
            }}
          ></textarea>
          <input
            type="button"
            className="btn btn-primary ms-auto"
            value="Submit"
            onClick={(e) => {
              handleSubmit(e);
            }}
          />
          {state.mailSent && <h2>Thank you for contacting me 😊</h2>}
        </form>
      </div>
    </div>
  );
}

export default App;
