//function for setting modals
const setModalRows = (props, date_options) => {
    let htmlToAppend = "";

    //reassign props to attributes
    const attributes = JSON.parse(JSON.stringify(props));

    //delete date fields to avoid sorting of fields in attributes
    delete attributes.created_at;
    delete attributes.updated_at;

    const attr = {
        //id must be on top
        id: attributes.id,
        ...attributes,
        //dates must be on bottom
        created_at: props.created_at,
        updated_at: props.updated_at,
    };

    //loop through and append dt element to htmlToAppend var
    Object.entries(attr)
        //removed the props that ends with _id and null/undefined values
        .filter(([key, value]) => !key.toLowerCase().endsWith("_id") && !!value)
        .forEach(([key, value]) => {
            //assign val to value or "NA" if present
            let val = value;

            //reassign updated_at to a formatted date
            if (key === "updated_at") {
                val = new Date(value);
                val = val.toLocaleDateString("en-us", date_options);
            }

            //append element string to htmlToAppend and format key to replace underscores with spaces
            htmlToAppend +=
                `<dt class="col-sm-4" style="text-transform: capitalize">${key.replace(
                    /_/gi,
                    " "
                )}</dt>
                        <dd class="col-sm-8">` +
                val +
                `</dd>`;
        });

    return htmlToAppend;
};
