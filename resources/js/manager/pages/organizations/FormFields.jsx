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
        }, {
            wrapperElement: {
                className: "mb-3",
            },
            labelElement: {
                htmlFor: "name",
                className: "form-label",
                text:  "Name"
            },
            inputElement: {
                id: "name",
                name: "name", 
                type: "text",
                className: "form-control", 
                placeholder: "Type a name..."
            },
            value: ""
        }, {
            wrapperElement: {
                className: "form-check form-switch my-4",
            },
            labelElement: {
                htmlFor: "status",
                className: "form-check-label",
                text:  "Is it an active user?"
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