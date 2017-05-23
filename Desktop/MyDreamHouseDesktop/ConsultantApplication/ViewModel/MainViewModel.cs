using GalaSoft.MvvmLight;
using SynchronisationLib;

namespace ConsultantApplication.ViewModel
{
    /// <summary>
    /// This class contains properties that the main View can data bind to.
    /// <para>
    /// Use the <strong>mvvminpc</strong> snippet to add bindable properties to this ViewModel.
    /// </para>
    /// <para>
    /// You can also use Blend to data bind with the tool's support.
    /// </para>
    /// <para>
    /// See http://www.galasoft.ch/mvvm
    /// </para>
    /// </summary>
    public class MainViewModel : ViewModelBase
    {
        private SyncService syncService = new SyncService();

        private string dummyProperty;

        public string DummyProperty
        {
            get { return dummyProperty; }
            set { dummyProperty = value; RaisePropertyChanged(); }
        }

        public MainViewModel()
        {
            DummyProperty = "Ping returned: " + syncService.Ping();
        }
    }
}