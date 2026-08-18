export const InputColor = ({ title, name, value, onChange }) => {
    const handleChange = (e) => {
        const { name, value } = e.target;
        onChange(name, value);
    };

    return (
        <div className="mb-6">
            <label className="block font-bold text-gray-500 mb-2">{title}</label>
            <div className="flex h-[52px] overflow-hidden rounded-lg border border-gray-300 w-20">
                <input
                    type="color"
                    name={name}
                    value={value}
                    onChange={handleChange}
                    className="h-full w-full border-0 bg-transparent p-1"
                />
            </div>
        </div>
    );
};
