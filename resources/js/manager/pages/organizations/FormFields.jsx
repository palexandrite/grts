export default function FormFields()
{
    return [
        { // ID
            wrapperElement: {
                className: "mb-2",
            },
            spanElement: {
                className: "text-secondary"
            },
            inputElement: {
                name: "id",
                type: "hidden"
            },
        },
        {
            wrapperElement: {
                className: "mb-3",
            },
            labelElement: {
                htmlFor: "name",
                className: "form-label",
                text:  "Company name"
            },
            inputElement: {
                id: "name",
                name: "name", 
                type: "text",
                className: "form-control", 
                placeholder: "Type a name..."
            },
            value: ""
        },
        {
            wrapperElement: {
                className: "mb-3",
            },
            labelElement: {
                htmlFor: "email",
                className: "form-label",
                text:  "Email"
            },
            inputElement: {
                id: "email",
                name: "email", 
                type: "email",
                className: "form-control",  
                placeholder: "Type an email..."
            },
            value: ""
        },
        {
            wrapperElement: {
                className: "mb-3",
            },
            labelElement: {
                htmlFor: "password",
                className: "form-label",
                text:  "Password"
            },
            inputElement: {
                id: "password",
                name: "password", 
                type: "password",
                className: "form-control",  
                placeholder: "Set a password..."
            },
            value: ""
        },
        {
            wrapperElement: {
                className: "form-check form-switch my-4",
            },
            labelElement: {
                htmlFor: "status",
                className: "form-check-label",
                text:  "Is it an active organization?"
            },
            inputElement: {
                id: "status",
                name: "status", 
                type: "checkbox",
                className: "form-check-input"
            },
            beginLayoutWith: "input",
            value: "Pending"
        },
    ];
}