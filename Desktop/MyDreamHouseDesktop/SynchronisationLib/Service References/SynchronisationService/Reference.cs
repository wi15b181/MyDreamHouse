﻿//------------------------------------------------------------------------------
// <auto-generated>
//     Dieser Code wurde von einem Tool generiert.
//     Laufzeitversion:4.0.30319.42000
//
//     Änderungen an dieser Datei können falsches Verhalten verursachen und gehen verloren, wenn
//     der Code erneut generiert wird.
// </auto-generated>
//------------------------------------------------------------------------------

namespace SynchronisationLib.SynchronisationService {
    
    
    [System.CodeDom.Compiler.GeneratedCodeAttribute("System.ServiceModel", "4.0.0.0")]
    [System.ServiceModel.ServiceContractAttribute(ConfigurationName="SynchronisationService.ISynchronisationWCF")]
    public interface ISynchronisationWCF {
        
        [System.ServiceModel.OperationContractAttribute(Action="http://tempuri.org/ISynchronisationWCF/Ping", ReplyAction="http://tempuri.org/ISynchronisationWCF/PingResponse")]
        int Ping();
        
        [System.ServiceModel.OperationContractAttribute(Action="http://tempuri.org/ISynchronisationWCF/Ping", ReplyAction="http://tempuri.org/ISynchronisationWCF/PingResponse")]
        System.Threading.Tasks.Task<int> PingAsync();
    }
    
    [System.CodeDom.Compiler.GeneratedCodeAttribute("System.ServiceModel", "4.0.0.0")]
    public interface ISynchronisationWCFChannel : SynchronisationLib.SynchronisationService.ISynchronisationWCF, System.ServiceModel.IClientChannel {
    }
    
    [System.Diagnostics.DebuggerStepThroughAttribute()]
    [System.CodeDom.Compiler.GeneratedCodeAttribute("System.ServiceModel", "4.0.0.0")]
    public partial class SynchronisationWCFClient : System.ServiceModel.ClientBase<SynchronisationLib.SynchronisationService.ISynchronisationWCF>, SynchronisationLib.SynchronisationService.ISynchronisationWCF {
        
        public SynchronisationWCFClient() {
        }
        
        public SynchronisationWCFClient(string endpointConfigurationName) : 
                base(endpointConfigurationName) {
        }
        
        public SynchronisationWCFClient(string endpointConfigurationName, string remoteAddress) : 
                base(endpointConfigurationName, remoteAddress) {
        }
        
        public SynchronisationWCFClient(string endpointConfigurationName, System.ServiceModel.EndpointAddress remoteAddress) : 
                base(endpointConfigurationName, remoteAddress) {
        }
        
        public SynchronisationWCFClient(System.ServiceModel.Channels.Binding binding, System.ServiceModel.EndpointAddress remoteAddress) : 
                base(binding, remoteAddress) {
        }
        
        public int Ping() {
            return base.Channel.Ping();
        }
        
        public System.Threading.Tasks.Task<int> PingAsync() {
            return base.Channel.PingAsync();
        }
    }
}