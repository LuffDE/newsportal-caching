import loadingGif from "../../assets/loading.gif"

const LoadingScreen = () => {
    return (
        <div className="flex items-center justify-center h-screen">
            <img
                src={loadingGif}
                alt="Loading..."
                className="w-46 h-67"
            />
        </div>
    );
};

export default LoadingScreen;