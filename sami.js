
window.projectVersion = 'master';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">[Global Namespace]</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Docker.html">Docker</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker.html">Docker</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Docker_Container" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Container.html">Container</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Container_Client" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Container/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Container_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Container/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Distribution" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Distribution.html">Distribution</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Distribution_Client" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Distribution/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Distribution_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Distribution/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Image" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Image.html">Image</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Image_Client" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Image/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Image_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Image/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Kernel" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Kernel.html">Kernel</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Kernel_Facade" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Kernel/Facade.html">Facade</a>                    </div>                </li>                            <li data-name="class:Docker_Kernel_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Kernel/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Network" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Network.html">Network</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Network_Client" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Network/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Network_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Network/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Plugin" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Plugin.html">Plugin</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Plugin_Client" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Plugin/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Plugin_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Plugin/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Swarm" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Swarm.html">Swarm</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Docker_Swarm_Config" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Swarm/Config.html">Config</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Swarm_Config_Client" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Config/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Swarm_Config_ServiceProvider" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Config/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Swarm_Node" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Swarm/Node.html">Node</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Swarm_Node_Client" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Node/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Swarm_Node_ServiceProvider" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Node/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Swarm_Secret" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Swarm/Secret.html">Secret</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Swarm_Secret_Client" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Secret/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Swarm_Secret_ServiceProvider" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Secret/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Swarm_Service" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Swarm/Service.html">Service</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Swarm_Service_Client" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Service/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Swarm_Service_ServiceProvider" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Service/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Swarm_Task" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Swarm/Task.html">Task</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Swarm_Task_Client" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Task/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Swarm_Task_ServiceProvider" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Docker/Swarm/Task/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Docker_Swarm_Client" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Swarm/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Swarm_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Swarm/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_System" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/System.html">System</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_System_Client" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/System/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_System_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/System/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Docker_Volume" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Docker/Volume.html">Volume</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Docker_Volume_Client" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Volume/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Docker_Volume_ServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Docker/Volume/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Docker_Docker" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Docker/Docker.html">Docker</a>                    </div>                </li>                            <li data-name="class:Docker_DockerTrait" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Docker/DockerTrait.html">DockerTrait</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": ".html", "name": "", "doc": "Namespace "},{"type": "Namespace", "link": "Docker.html", "name": "Docker", "doc": "Namespace Docker"},{"type": "Namespace", "link": "Docker/Container.html", "name": "Docker\\Container", "doc": "Namespace Docker\\Container"},{"type": "Namespace", "link": "Docker/Distribution.html", "name": "Docker\\Distribution", "doc": "Namespace Docker\\Distribution"},{"type": "Namespace", "link": "Docker/Image.html", "name": "Docker\\Image", "doc": "Namespace Docker\\Image"},{"type": "Namespace", "link": "Docker/Kernel.html", "name": "Docker\\Kernel", "doc": "Namespace Docker\\Kernel"},{"type": "Namespace", "link": "Docker/Network.html", "name": "Docker\\Network", "doc": "Namespace Docker\\Network"},{"type": "Namespace", "link": "Docker/Plugin.html", "name": "Docker\\Plugin", "doc": "Namespace Docker\\Plugin"},{"type": "Namespace", "link": "Docker/Swarm.html", "name": "Docker\\Swarm", "doc": "Namespace Docker\\Swarm"},{"type": "Namespace", "link": "Docker/Swarm/Config.html", "name": "Docker\\Swarm\\Config", "doc": "Namespace Docker\\Swarm\\Config"},{"type": "Namespace", "link": "Docker/Swarm/Node.html", "name": "Docker\\Swarm\\Node", "doc": "Namespace Docker\\Swarm\\Node"},{"type": "Namespace", "link": "Docker/Swarm/Secret.html", "name": "Docker\\Swarm\\Secret", "doc": "Namespace Docker\\Swarm\\Secret"},{"type": "Namespace", "link": "Docker/Swarm/Service.html", "name": "Docker\\Swarm\\Service", "doc": "Namespace Docker\\Swarm\\Service"},{"type": "Namespace", "link": "Docker/Swarm/Task.html", "name": "Docker\\Swarm\\Task", "doc": "Namespace Docker\\Swarm\\Task"},{"type": "Namespace", "link": "Docker/System.html", "name": "Docker\\System", "doc": "Namespace Docker\\System"},{"type": "Namespace", "link": "Docker/Volume.html", "name": "Docker\\Volume", "doc": "Namespace Docker\\Volume"},
            
            {"type": "Class",  "link": "Docker.html", "name": "Docker", "doc": "&quot;&quot;"},
                    
            {"type": "Class", "fromName": "Docker\\Container", "fromLink": "Docker/Container.html", "link": "Docker/Container/Client.html", "name": "Docker\\Container\\Client", "doc": "&quot;Container.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCmd", "name": "Docker\\Container\\Client::setCmd", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setImage", "name": "Docker\\Container\\Client::setImage", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setContainerName", "name": "Docker\\Container\\Client::setContainerName", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setNetworkingConfig", "name": "Docker\\Container\\Client::setNetworkingConfig", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setHostname", "name": "Docker\\Container\\Client::setHostname", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setDomainname", "name": "Docker\\Container\\Client::setDomainname", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setUser", "name": "Docker\\Container\\Client::setUser", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setAttachStdin", "name": "Docker\\Container\\Client::setAttachStdin", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setAttachStdout", "name": "Docker\\Container\\Client::setAttachStdout", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setAttachStderr", "name": "Docker\\Container\\Client::setAttachStderr", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setExposedPorts", "name": "Docker\\Container\\Client::setExposedPorts", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setTty", "name": "Docker\\Container\\Client::setTty", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setOpenStdin", "name": "Docker\\Container\\Client::setOpenStdin", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setStdinOnce", "name": "Docker\\Container\\Client::setStdinOnce", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setEnv", "name": "Docker\\Container\\Client::setEnv", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setHealthcheck", "name": "Docker\\Container\\Client::setHealthcheck", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setArgsEscaped", "name": "Docker\\Container\\Client::setArgsEscaped", "doc": "&quot;Command is already escaped (Windows only).&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setVolumes", "name": "Docker\\Container\\Client::setVolumes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setWorkingDir", "name": "Docker\\Container\\Client::setWorkingDir", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setEntrypoint", "name": "Docker\\Container\\Client::setEntrypoint", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setNetworkDisabled", "name": "Docker\\Container\\Client::setNetworkDisabled", "doc": "&quot;Disable networking for the container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setMacAddress", "name": "Docker\\Container\\Client::setMacAddress", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setOnBuild", "name": "Docker\\Container\\Client::setOnBuild", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setLabels", "name": "Docker\\Container\\Client::setLabels", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setStopSignal", "name": "Docker\\Container\\Client::setStopSignal", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setStopTimeout", "name": "Docker\\Container\\Client::setStopTimeout", "doc": "&quot;Timeout to stop a container in seconds.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setShell", "name": "Docker\\Container\\Client::setShell", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpuShares", "name": "Docker\\Container\\Client::setCpuShares", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setMemory", "name": "Docker\\Container\\Client::setMemory", "doc": "&quot;Memory limit in bytes.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCgroupParent", "name": "Docker\\Container\\Client::setCgroupParent", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setBlkioWeight", "name": "Docker\\Container\\Client::setBlkioWeight", "doc": "&quot;[ 0 .&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setBlkioWeightDevice", "name": "Docker\\Container\\Client::setBlkioWeightDevice", "doc": "&quot;$param array&lt;object&gt; $blkioWeightDevice.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setBlkioDeviceReadBps", "name": "Docker\\Container\\Client::setBlkioDeviceReadBps", "doc": "&quot;[{\&quot;Path\&quot;: \&quot;device_path\&quot;, \&quot;Rate\&quot;: rate}].&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setBlkioDeviceWriteBps", "name": "Docker\\Container\\Client::setBlkioDeviceWriteBps", "doc": "&quot;[{\&quot;Path\&quot;: \&quot;device_path\&quot;, \&quot;Rate\&quot;: rate}].&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setBlkioDeviceReadIOps", "name": "Docker\\Container\\Client::setBlkioDeviceReadIOps", "doc": "&quot;[{\&quot;Path\&quot;: \&quot;device_path\&quot;, \&quot;Rate\&quot;: rate}].&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setBlkioDeviceWriteIOps", "name": "Docker\\Container\\Client::setBlkioDeviceWriteIOps", "doc": "&quot;[{\&quot;Path\&quot;: \&quot;device_path\&quot;, \&quot;Rate\&quot;: rate}].&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpuPeriod", "name": "Docker\\Container\\Client::setCpuPeriod", "doc": "&quot;The length of a CPU period in microseconds.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpuQuota", "name": "Docker\\Container\\Client::setCpuQuota", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpuRealtimePeriod", "name": "Docker\\Container\\Client::setCpuRealtimePeriod", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpuRealtimeRuntime", "name": "Docker\\Container\\Client::setCpuRealtimeRuntime", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpusetCpus", "name": "Docker\\Container\\Client::setCpusetCpus", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpusetMems", "name": "Docker\\Container\\Client::setCpusetMems", "doc": "&quot;Memory nodes (MEMs) in which to allow execution (0-3, 0,1). Only effective on NUMA systems.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setDevices", "name": "Docker\\Container\\Client::setDevices", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setDeviceCgroupRules", "name": "Docker\\Container\\Client::setDeviceCgroupRules", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setKernelMemory", "name": "Docker\\Container\\Client::setKernelMemory", "doc": "&quot;Kernel memory limit in bytes.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setMemoryReservation", "name": "Docker\\Container\\Client::setMemoryReservation", "doc": "&quot;Memory soft limit in bytes.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setMemorySwap", "name": "Docker\\Container\\Client::setMemorySwap", "doc": "&quot;Total memory limit (memory + swap). Set as -1 to enable unlimited swap.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setMemorySwappiness", "name": "Docker\\Container\\Client::setMemorySwappiness", "doc": "&quot;[ 0 .&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setNanoCPUs", "name": "Docker\\Container\\Client::setNanoCPUs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setOomKillDisable", "name": "Docker\\Container\\Client::setOomKillDisable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setInit", "name": "Docker\\Container\\Client::setInit", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setPidsLimit", "name": "Docker\\Container\\Client::setPidsLimit", "doc": "&quot;Tune a container&#039;s PIDs limit. Set 0 or -1 for unlimited, or null to not change.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setUlimits", "name": "Docker\\Container\\Client::setUlimits", "doc": "&quot;{\&quot;Name\&quot;: \&quot;nofile\&quot;, \&quot;Soft\&quot;: 1024, \&quot;Hard\&quot;: 2048}.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpuCount", "name": "Docker\\Container\\Client::setCpuCount", "doc": "&quot;The number of usable CPUs (Windows only).&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCpuPercent", "name": "Docker\\Container\\Client::setCpuPercent", "doc": "&quot;The usable percentage of the available CPUs (Windows only).&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setIOMaximumIOps", "name": "Docker\\Container\\Client::setIOMaximumIOps", "doc": "&quot;Maximum IOps for the container system drive (Windows only).&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setIOMaximumBandWidth", "name": "Docker\\Container\\Client::setIOMaximumBandWidth", "doc": "&quot;Maximum IO in bytes per second for the container system drive (Windows only).&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setBinds", "name": "Docker\\Container\\Client::setBinds", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setContainerIDFile", "name": "Docker\\Container\\Client::setContainerIDFile", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setLogConfig", "name": "Docker\\Container\\Client::setLogConfig", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setNetworkMode", "name": "Docker\\Container\\Client::setNetworkMode", "doc": "&quot;bridge, host, none, and container:&amp;lt;name|id&gt;.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setPortBindings", "name": "Docker\\Container\\Client::setPortBindings", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setRestartPolicy", "name": "Docker\\Container\\Client::setRestartPolicy", "doc": "&quot;\&quot;\&quot; \&quot;always\&quot; \&quot;unless-stopped\&quot; \&quot;on-failure\&quot;.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setAutoRemove", "name": "Docker\\Container\\Client::setAutoRemove", "doc": "&quot;Automatically remove the container when the container&#039;s process exits.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setVolumeDriver", "name": "Docker\\Container\\Client::setVolumeDriver", "doc": "&quot;Driver that this container uses to mount volumes.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setVolumesFrom", "name": "Docker\\Container\\Client::setVolumesFrom", "doc": "&quot;A list of volumes to inherit from another container,\nspecified in the form &lt;container name&gt;[:&amp;lt;ro|rw&gt;].&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setMounts", "name": "Docker\\Container\\Client::setMounts", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCapAdd", "name": "Docker\\Container\\Client::setCapAdd", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCapDrop", "name": "Docker\\Container\\Client::setCapDrop", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setDns", "name": "Docker\\Container\\Client::setDns", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setDnsOptions", "name": "Docker\\Container\\Client::setDnsOptions", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setDnsSearch", "name": "Docker\\Container\\Client::setDnsSearch", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setExtraHosts", "name": "Docker\\Container\\Client::setExtraHosts", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setGroupAdd", "name": "Docker\\Container\\Client::setGroupAdd", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setIpcMode", "name": "Docker\\Container\\Client::setIpcMode", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCgroup", "name": "Docker\\Container\\Client::setCgroup", "doc": "&quot;Cgroup to use for the container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setOomScoreAdj", "name": "Docker\\Container\\Client::setOomScoreAdj", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setPidMode", "name": "Docker\\Container\\Client::setPidMode", "doc": "&quot;\&quot;container:&amp;lt;name|id&gt;\&quot; | \&quot;host\&quot;.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setPrivileged", "name": "Docker\\Container\\Client::setPrivileged", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setPublishAllPorts", "name": "Docker\\Container\\Client::setPublishAllPorts", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setReadonlyRootfs", "name": "Docker\\Container\\Client::setReadonlyRootfs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setSecurityOpt", "name": "Docker\\Container\\Client::setSecurityOpt", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setStorageOpt", "name": "Docker\\Container\\Client::setStorageOpt", "doc": "&quot;{\&quot;size\&quot;: \&quot;120G\&quot;}.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setTmpfs", "name": "Docker\\Container\\Client::setTmpfs", "doc": "&quot;{ \&quot;\/run\&quot;: \&quot;rw,noexec,nosuid,size=65536k\&quot; }.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setUTSMode", "name": "Docker\\Container\\Client::setUTSMode", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setUsernsMode", "name": "Docker\\Container\\Client::setUsernsMode", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setShmSize", "name": "Docker\\Container\\Client::setShmSize", "doc": "&quot;&lt;blockquote&gt;\n  &lt;p&gt;= 0.&lt;\/p&gt;\n&lt;\/blockquote&gt;\n&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setSysctls", "name": "Docker\\Container\\Client::setSysctls", "doc": "&quot;{\&quot;net.ipv4.ip_forward\&quot;: \&quot;1\&quot;}.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setRuntime", "name": "Docker\\Container\\Client::setRuntime", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setConsoleSize", "name": "Docker\\Container\\Client::setConsoleSize", "doc": "&quot;item integer &gt;= 0.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setIsolation", "name": "Docker\\Container\\Client::setIsolation", "doc": "&quot;\&quot;default\&quot; \&quot;process\&quot; \&quot;hyperv\&quot;.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_getContainerId", "name": "Docker\\Container\\Client::getContainerId", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setContainerId", "name": "Docker\\Container\\Client::setContainerId", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_checkFilter", "name": "Docker\\Container\\Client::checkFilter", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method___construct", "name": "Docker\\Container\\Client::__construct", "doc": "&quot;Container constructor.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_list", "name": "Docker\\Container\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_setCreateJson", "name": "Docker\\Container\\Client::setCreateJson", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_getCreateJson", "name": "Docker\\Container\\Client::getCreateJson", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_create", "name": "Docker\\Container\\Client::create", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_inspect", "name": "Docker\\Container\\Client::inspect", "doc": "&quot;Inspect a container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_top", "name": "Docker\\Container\\Client::top", "doc": "&quot;List processes running inside a container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_logs", "name": "Docker\\Container\\Client::logs", "doc": "&quot;Get container logs.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_changes", "name": "Docker\\Container\\Client::changes", "doc": "&quot;Get changes on a container\u2019s filesystem.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_export", "name": "Docker\\Container\\Client::export", "doc": "&quot;Export a container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_stats", "name": "Docker\\Container\\Client::stats", "doc": "&quot;Get container stats based on resource usage.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_resize", "name": "Docker\\Container\\Client::resize", "doc": "&quot;Resize a container TTY.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_start", "name": "Docker\\Container\\Client::start", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_stop", "name": "Docker\\Container\\Client::stop", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_restart", "name": "Docker\\Container\\Client::restart", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_kill", "name": "Docker\\Container\\Client::kill", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_update", "name": "Docker\\Container\\Client::update", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_rename", "name": "Docker\\Container\\Client::rename", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_pause", "name": "Docker\\Container\\Client::pause", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_unpause", "name": "Docker\\Container\\Client::unpause", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_attach", "name": "Docker\\Container\\Client::attach", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_attachViaWebSocket", "name": "Docker\\Container\\Client::attachViaWebSocket", "doc": "&quot;Attach to a container via a websocket.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_wait", "name": "Docker\\Container\\Client::wait", "doc": "&quot;Wait for a container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_remove", "name": "Docker\\Container\\Client::remove", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_getFileInfo", "name": "Docker\\Container\\Client::getFileInfo", "doc": "&quot;Get information about files in a container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_archive", "name": "Docker\\Container\\Client::archive", "doc": "&quot;Get an archive of a filesystem resource in a container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_extract", "name": "Docker\\Container\\Client::extract", "doc": "&quot;Extract an archive of files or folders to a directory in a container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_prune", "name": "Docker\\Container\\Client::prune", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_createExec", "name": "Docker\\Container\\Client::createExec", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_startExec", "name": "Docker\\Container\\Client::startExec", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_resizeExec", "name": "Docker\\Container\\Client::resizeExec", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Container\\Client", "fromLink": "Docker/Container/Client.html", "link": "Docker/Container/Client.html#method_inspectExec", "name": "Docker\\Container\\Client::inspectExec", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Container", "fromLink": "Docker/Container.html", "link": "Docker/Container/ServiceProvider.html", "name": "Docker\\Container\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Container\\ServiceProvider", "fromLink": "Docker/Container/ServiceProvider.html", "link": "Docker/Container/ServiceProvider.html#method_register", "name": "Docker\\Container\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Distribution", "fromLink": "Docker/Distribution.html", "link": "Docker/Distribution/Client.html", "name": "Docker\\Distribution\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Distribution\\Client", "fromLink": "Docker/Distribution/Client.html", "link": "Docker/Distribution/Client.html#method_info", "name": "Docker\\Distribution\\Client::info", "doc": "&quot;Get image information from the registry.&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Distribution", "fromLink": "Docker/Distribution.html", "link": "Docker/Distribution/ServiceProvider.html", "name": "Docker\\Distribution\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Distribution\\ServiceProvider", "fromLink": "Docker/Distribution/ServiceProvider.html", "link": "Docker/Distribution/ServiceProvider.html#method_register", "name": "Docker\\Distribution\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker", "fromLink": "Docker.html", "link": "Docker/Docker.html", "name": "Docker\\Docker", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Docker", "fromLink": "Docker/Docker.html", "link": "Docker/Docker.html#method___construct", "name": "Docker\\Docker::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Docker", "fromLink": "Docker/Docker.html", "link": "Docker/Docker.html#method_createOptionArray", "name": "Docker\\Docker::createOptionArray", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Docker", "fromLink": "Docker/Docker.html", "link": "Docker/Docker.html#method_connection", "name": "Docker\\Docker::connection", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Docker", "fromLink": "Docker/Docker.html", "link": "Docker/Docker.html#method_docker", "name": "Docker\\Docker::docker", "doc": "&quot;\u5355\u4f8b\u6a21\u5f0f.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Docker", "fromLink": "Docker/Docker.html", "link": "Docker/Docker.html#method___get", "name": "Docker\\Docker::__get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Docker", "fromLink": "Docker/Docker.html", "link": "Docker/Docker.html#method___call", "name": "Docker\\Docker::__call", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Docker", "fromLink": "Docker/Docker.html", "link": "Docker/Docker.html#method_version", "name": "Docker\\Docker::version", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Docker", "fromLink": "Docker/Docker.html", "link": "Docker/Docker.html#method_config", "name": "Docker\\Docker::config", "doc": "&quot;&quot;"},
            
            {"type": "Trait", "fromName": "Docker", "fromLink": "Docker.html", "link": "Docker/DockerTrait.html", "name": "Docker\\DockerTrait", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\DockerTrait", "fromLink": "Docker/DockerTrait.html", "link": "Docker/DockerTrait.html#method___construct", "name": "Docker\\DockerTrait::__construct", "doc": "&quot;Volume constructor.&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Image", "fromLink": "Docker/Image.html", "link": "Docker/Image/Client.html", "name": "Docker\\Image\\Client", "doc": "&quot;Image.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method___construct", "name": "Docker\\Image\\Client::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_list", "name": "Docker\\Image\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_build", "name": "Docker\\Image\\Client::build", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_deleteBuildCache", "name": "Docker\\Image\\Client::deleteBuildCache", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_parseImage", "name": "Docker\\Image\\Client::parseImage", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_pull", "name": "Docker\\Image\\Client::pull", "doc": "&quot;\u5982\u679c tag \u4e3a\u7a7a\uff0c\u5219\u62c9\u53d6\u6240\u6709\u6807\u7b7e\uff0c\u6240\u4ee5\u5fc5\u987b\u6307\u5b9a\u540d\u79f0\n\u989d\u5916\u589e\u52a0 $force \u53c2\u6570\uff0c\u62c9\u53d6\u524d\u9996\u5148\u5224\u65ad\u662f\u5426\u5df2\u5b58\u5728\u3002&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_import", "name": "Docker\\Image\\Client::import", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_inspect", "name": "Docker\\Image\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_history", "name": "Docker\\Image\\Client::history", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_push", "name": "Docker\\Image\\Client::push", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_tag", "name": "Docker\\Image\\Client::tag", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_remove", "name": "Docker\\Image\\Client::remove", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_search", "name": "Docker\\Image\\Client::search", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_prune", "name": "Docker\\Image\\Client::prune", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_commit", "name": "Docker\\Image\\Client::commit", "doc": "&quot;Create a new image from a container.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_export", "name": "Docker\\Image\\Client::export", "doc": "&quot;Get a tarball containing all images and metadata for a repository.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_exports", "name": "Docker\\Image\\Client::exports", "doc": "&quot;Get a tarball containing all images and metadata for several image repositories.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Image\\Client", "fromLink": "Docker/Image/Client.html", "link": "Docker/Image/Client.html#method_load", "name": "Docker\\Image\\Client::load", "doc": "&quot;Load a set of images and tags into a repository.&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Image", "fromLink": "Docker/Image.html", "link": "Docker/Image/ServiceProvider.html", "name": "Docker\\Image\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Image\\ServiceProvider", "fromLink": "Docker/Image/ServiceProvider.html", "link": "Docker/Image/ServiceProvider.html#method_register", "name": "Docker\\Image\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Kernel", "fromLink": "Docker/Kernel.html", "link": "Docker/Kernel/Facade.html", "name": "Docker\\Kernel\\Facade", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Kernel\\Facade", "fromLink": "Docker/Kernel/Facade.html", "link": "Docker/Kernel/Facade.html#method_getFacadeAccessor", "name": "Docker\\Kernel\\Facade::getFacadeAccessor", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Kernel", "fromLink": "Docker/Kernel.html", "link": "Docker/Kernel/ServiceProvider.html", "name": "Docker\\Kernel\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Kernel\\ServiceProvider", "fromLink": "Docker/Kernel/ServiceProvider.html", "link": "Docker/Kernel/ServiceProvider.html#method_boot", "name": "Docker\\Kernel\\ServiceProvider::boot", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Kernel\\ServiceProvider", "fromLink": "Docker/Kernel/ServiceProvider.html", "link": "Docker/Kernel/ServiceProvider.html#method_register", "name": "Docker\\Kernel\\ServiceProvider::register", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Kernel\\ServiceProvider", "fromLink": "Docker/Kernel/ServiceProvider.html", "link": "Docker/Kernel/ServiceProvider.html#method_provides", "name": "Docker\\Kernel\\ServiceProvider::provides", "doc": "&quot;\u83b7\u53d6\u63d0\u4f9b\u5668\u63d0\u4f9b\u7684\u670d\u52a1\u3002&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Network", "fromLink": "Docker/Network.html", "link": "Docker/Network/Client.html", "name": "Docker\\Network\\Client", "doc": "&quot;Network.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Network\\Client", "fromLink": "Docker/Network/Client.html", "link": "Docker/Network/Client.html#method___construct", "name": "Docker\\Network\\Client::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Network\\Client", "fromLink": "Docker/Network/Client.html", "link": "Docker/Network/Client.html#method_list", "name": "Docker\\Network\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Network\\Client", "fromLink": "Docker/Network/Client.html", "link": "Docker/Network/Client.html#method_inspect", "name": "Docker\\Network\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Network\\Client", "fromLink": "Docker/Network/Client.html", "link": "Docker/Network/Client.html#method_remove", "name": "Docker\\Network\\Client::remove", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Network\\Client", "fromLink": "Docker/Network/Client.html", "link": "Docker/Network/Client.html#method_create", "name": "Docker\\Network\\Client::create", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Network\\Client", "fromLink": "Docker/Network/Client.html", "link": "Docker/Network/Client.html#method_connect", "name": "Docker\\Network\\Client::connect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Network\\Client", "fromLink": "Docker/Network/Client.html", "link": "Docker/Network/Client.html#method_disConnect", "name": "Docker\\Network\\Client::disConnect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Network\\Client", "fromLink": "Docker/Network/Client.html", "link": "Docker/Network/Client.html#method_prune", "name": "Docker\\Network\\Client::prune", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Network", "fromLink": "Docker/Network.html", "link": "Docker/Network/ServiceProvider.html", "name": "Docker\\Network\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Network\\ServiceProvider", "fromLink": "Docker/Network/ServiceProvider.html", "link": "Docker/Network/ServiceProvider.html#method_register", "name": "Docker\\Network\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Plugin", "fromLink": "Docker/Plugin.html", "link": "Docker/Plugin/Client.html", "name": "Docker\\Plugin\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method___construct", "name": "Docker\\Plugin\\Client::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_list", "name": "Docker\\Plugin\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_getPrivileges", "name": "Docker\\Plugin\\Client::getPrivileges", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_install", "name": "Docker\\Plugin\\Client::install", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_inspect", "name": "Docker\\Plugin\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_remove", "name": "Docker\\Plugin\\Client::remove", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_enable", "name": "Docker\\Plugin\\Client::enable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_disable", "name": "Docker\\Plugin\\Client::disable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_upgrade", "name": "Docker\\Plugin\\Client::upgrade", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_create", "name": "Docker\\Plugin\\Client::create", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_push", "name": "Docker\\Plugin\\Client::push", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Plugin\\Client", "fromLink": "Docker/Plugin/Client.html", "link": "Docker/Plugin/Client.html#method_config", "name": "Docker\\Plugin\\Client::config", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Plugin", "fromLink": "Docker/Plugin.html", "link": "Docker/Plugin/ServiceProvider.html", "name": "Docker\\Plugin\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Plugin\\ServiceProvider", "fromLink": "Docker/Plugin/ServiceProvider.html", "link": "Docker/Plugin/ServiceProvider.html#method_register", "name": "Docker\\Plugin\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm", "fromLink": "Docker/Swarm.html", "link": "Docker/Swarm/Client.html", "name": "Docker\\Swarm\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Client", "fromLink": "Docker/Swarm/Client.html", "link": "Docker/Swarm/Client.html#method___construct", "name": "Docker\\Swarm\\Client::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Client", "fromLink": "Docker/Swarm/Client.html", "link": "Docker/Swarm/Client.html#method_inspect", "name": "Docker\\Swarm\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Client", "fromLink": "Docker/Swarm/Client.html", "link": "Docker/Swarm/Client.html#method_initialize", "name": "Docker\\Swarm\\Client::initialize", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Client", "fromLink": "Docker/Swarm/Client.html", "link": "Docker/Swarm/Client.html#method_join", "name": "Docker\\Swarm\\Client::join", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Client", "fromLink": "Docker/Swarm/Client.html", "link": "Docker/Swarm/Client.html#method_leave", "name": "Docker\\Swarm\\Client::leave", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Client", "fromLink": "Docker/Swarm/Client.html", "link": "Docker/Swarm/Client.html#method_update", "name": "Docker\\Swarm\\Client::update", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Client", "fromLink": "Docker/Swarm/Client.html", "link": "Docker/Swarm/Client.html#method_getUnlockKey", "name": "Docker\\Swarm\\Client::getUnlockKey", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Client", "fromLink": "Docker/Swarm/Client.html", "link": "Docker/Swarm/Client.html#method_unlock", "name": "Docker\\Swarm\\Client::unlock", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Config", "fromLink": "Docker/Swarm/Config.html", "link": "Docker/Swarm/Config/Client.html", "name": "Docker\\Swarm\\Config\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Config\\Client", "fromLink": "Docker/Swarm/Config/Client.html", "link": "Docker/Swarm/Config/Client.html#method___construct", "name": "Docker\\Swarm\\Config\\Client::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Config\\Client", "fromLink": "Docker/Swarm/Config/Client.html", "link": "Docker/Swarm/Config/Client.html#method_list", "name": "Docker\\Swarm\\Config\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Config\\Client", "fromLink": "Docker/Swarm/Config/Client.html", "link": "Docker/Swarm/Config/Client.html#method_create", "name": "Docker\\Swarm\\Config\\Client::create", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Config\\Client", "fromLink": "Docker/Swarm/Config/Client.html", "link": "Docker/Swarm/Config/Client.html#method_inspect", "name": "Docker\\Swarm\\Config\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Config\\Client", "fromLink": "Docker/Swarm/Config/Client.html", "link": "Docker/Swarm/Config/Client.html#method_delete", "name": "Docker\\Swarm\\Config\\Client::delete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Config\\Client", "fromLink": "Docker/Swarm/Config/Client.html", "link": "Docker/Swarm/Config/Client.html#method_update", "name": "Docker\\Swarm\\Config\\Client::update", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Config", "fromLink": "Docker/Swarm/Config.html", "link": "Docker/Swarm/Config/ServiceProvider.html", "name": "Docker\\Swarm\\Config\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Config\\ServiceProvider", "fromLink": "Docker/Swarm/Config/ServiceProvider.html", "link": "Docker/Swarm/Config/ServiceProvider.html#method_register", "name": "Docker\\Swarm\\Config\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Node", "fromLink": "Docker/Swarm/Node.html", "link": "Docker/Swarm/Node/Client.html", "name": "Docker\\Swarm\\Node\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Node\\Client", "fromLink": "Docker/Swarm/Node/Client.html", "link": "Docker/Swarm/Node/Client.html#method_list", "name": "Docker\\Swarm\\Node\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Node\\Client", "fromLink": "Docker/Swarm/Node/Client.html", "link": "Docker/Swarm/Node/Client.html#method_inspect", "name": "Docker\\Swarm\\Node\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Node\\Client", "fromLink": "Docker/Swarm/Node/Client.html", "link": "Docker/Swarm/Node/Client.html#method_delete", "name": "Docker\\Swarm\\Node\\Client::delete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Node\\Client", "fromLink": "Docker/Swarm/Node/Client.html", "link": "Docker/Swarm/Node/Client.html#method_update", "name": "Docker\\Swarm\\Node\\Client::update", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Node", "fromLink": "Docker/Swarm/Node.html", "link": "Docker/Swarm/Node/ServiceProvider.html", "name": "Docker\\Swarm\\Node\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Node\\ServiceProvider", "fromLink": "Docker/Swarm/Node/ServiceProvider.html", "link": "Docker/Swarm/Node/ServiceProvider.html#method_register", "name": "Docker\\Swarm\\Node\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Secret", "fromLink": "Docker/Swarm/Secret.html", "link": "Docker/Swarm/Secret/Client.html", "name": "Docker\\Swarm\\Secret\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Secret\\Client", "fromLink": "Docker/Swarm/Secret/Client.html", "link": "Docker/Swarm/Secret/Client.html#method___construct", "name": "Docker\\Swarm\\Secret\\Client::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Secret\\Client", "fromLink": "Docker/Swarm/Secret/Client.html", "link": "Docker/Swarm/Secret/Client.html#method_list", "name": "Docker\\Swarm\\Secret\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Secret\\Client", "fromLink": "Docker/Swarm/Secret/Client.html", "link": "Docker/Swarm/Secret/Client.html#method_create", "name": "Docker\\Swarm\\Secret\\Client::create", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Secret\\Client", "fromLink": "Docker/Swarm/Secret/Client.html", "link": "Docker/Swarm/Secret/Client.html#method_inspect", "name": "Docker\\Swarm\\Secret\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Secret\\Client", "fromLink": "Docker/Swarm/Secret/Client.html", "link": "Docker/Swarm/Secret/Client.html#method_delete", "name": "Docker\\Swarm\\Secret\\Client::delete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Secret\\Client", "fromLink": "Docker/Swarm/Secret/Client.html", "link": "Docker/Swarm/Secret/Client.html#method_update", "name": "Docker\\Swarm\\Secret\\Client::update", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Secret", "fromLink": "Docker/Swarm/Secret.html", "link": "Docker/Swarm/Secret/ServiceProvider.html", "name": "Docker\\Swarm\\Secret\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Secret\\ServiceProvider", "fromLink": "Docker/Swarm/Secret/ServiceProvider.html", "link": "Docker/Swarm/Secret/ServiceProvider.html#method_register", "name": "Docker\\Swarm\\Secret\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm", "fromLink": "Docker/Swarm.html", "link": "Docker/Swarm/ServiceProvider.html", "name": "Docker\\Swarm\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\ServiceProvider", "fromLink": "Docker/Swarm/ServiceProvider.html", "link": "Docker/Swarm/ServiceProvider.html#method_register", "name": "Docker\\Swarm\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Service", "fromLink": "Docker/Swarm/Service.html", "link": "Docker/Swarm/Service/Client.html", "name": "Docker\\Swarm\\Service\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Service\\Client", "fromLink": "Docker/Swarm/Service/Client.html", "link": "Docker/Swarm/Service/Client.html#method_list", "name": "Docker\\Swarm\\Service\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Service\\Client", "fromLink": "Docker/Swarm/Service/Client.html", "link": "Docker/Swarm/Service/Client.html#method_create", "name": "Docker\\Swarm\\Service\\Client::create", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Service\\Client", "fromLink": "Docker/Swarm/Service/Client.html", "link": "Docker/Swarm/Service/Client.html#method_inspect", "name": "Docker\\Swarm\\Service\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Service\\Client", "fromLink": "Docker/Swarm/Service/Client.html", "link": "Docker/Swarm/Service/Client.html#method_delete", "name": "Docker\\Swarm\\Service\\Client::delete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Service\\Client", "fromLink": "Docker/Swarm/Service/Client.html", "link": "Docker/Swarm/Service/Client.html#method_update", "name": "Docker\\Swarm\\Service\\Client::update", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Service\\Client", "fromLink": "Docker/Swarm/Service/Client.html", "link": "Docker/Swarm/Service/Client.html#method_logs", "name": "Docker\\Swarm\\Service\\Client::logs", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Service", "fromLink": "Docker/Swarm/Service.html", "link": "Docker/Swarm/Service/ServiceProvider.html", "name": "Docker\\Swarm\\Service\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Service\\ServiceProvider", "fromLink": "Docker/Swarm/Service/ServiceProvider.html", "link": "Docker/Swarm/Service/ServiceProvider.html#method_register", "name": "Docker\\Swarm\\Service\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Task", "fromLink": "Docker/Swarm/Task.html", "link": "Docker/Swarm/Task/Client.html", "name": "Docker\\Swarm\\Task\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Task\\Client", "fromLink": "Docker/Swarm/Task/Client.html", "link": "Docker/Swarm/Task/Client.html#method___construct", "name": "Docker\\Swarm\\Task\\Client::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Task\\Client", "fromLink": "Docker/Swarm/Task/Client.html", "link": "Docker/Swarm/Task/Client.html#method_list", "name": "Docker\\Swarm\\Task\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Task\\Client", "fromLink": "Docker/Swarm/Task/Client.html", "link": "Docker/Swarm/Task/Client.html#method_inspect", "name": "Docker\\Swarm\\Task\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Swarm\\Task\\Client", "fromLink": "Docker/Swarm/Task/Client.html", "link": "Docker/Swarm/Task/Client.html#method_logs", "name": "Docker\\Swarm\\Task\\Client::logs", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Swarm\\Task", "fromLink": "Docker/Swarm/Task.html", "link": "Docker/Swarm/Task/ServiceProvider.html", "name": "Docker\\Swarm\\Task\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Swarm\\Task\\ServiceProvider", "fromLink": "Docker/Swarm/Task/ServiceProvider.html", "link": "Docker/Swarm/Task/ServiceProvider.html#method_register", "name": "Docker\\Swarm\\Task\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\System", "fromLink": "Docker/System.html", "link": "Docker/System/Client.html", "name": "Docker\\System\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method___construct", "name": "Docker\\System\\Client::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method_checkAuthConfig", "name": "Docker\\System\\Client::checkAuthConfig", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method_authJson", "name": "Docker\\System\\Client::authJson", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method_info", "name": "Docker\\System\\Client::info", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method_version", "name": "Docker\\System\\Client::version", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method_arch", "name": "Docker\\System\\Client::arch", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method_ping", "name": "Docker\\System\\Client::ping", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method_events", "name": "Docker\\System\\Client::events", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\System\\Client", "fromLink": "Docker/System/Client.html", "link": "Docker/System/Client.html#method_dataUsageInfo", "name": "Docker\\System\\Client::dataUsageInfo", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\System", "fromLink": "Docker/System.html", "link": "Docker/System/ServiceProvider.html", "name": "Docker\\System\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\System\\ServiceProvider", "fromLink": "Docker/System/ServiceProvider.html", "link": "Docker/System/ServiceProvider.html#method_register", "name": "Docker\\System\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Volume", "fromLink": "Docker/Volume.html", "link": "Docker/Volume/Client.html", "name": "Docker\\Volume\\Client", "doc": "&quot;Class Client.&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Volume\\Client", "fromLink": "Docker/Volume/Client.html", "link": "Docker/Volume/Client.html#method___construct", "name": "Docker\\Volume\\Client::__construct", "doc": "&quot;Volume constructor.&quot;"},
                    {"type": "Method", "fromName": "Docker\\Volume\\Client", "fromLink": "Docker/Volume/Client.html", "link": "Docker/Volume/Client.html#method_list", "name": "Docker\\Volume\\Client::list", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Volume\\Client", "fromLink": "Docker/Volume/Client.html", "link": "Docker/Volume/Client.html#method_create", "name": "Docker\\Volume\\Client::create", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Volume\\Client", "fromLink": "Docker/Volume/Client.html", "link": "Docker/Volume/Client.html#method_inspect", "name": "Docker\\Volume\\Client::inspect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Volume\\Client", "fromLink": "Docker/Volume/Client.html", "link": "Docker/Volume/Client.html#method_remove", "name": "Docker\\Volume\\Client::remove", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Docker\\Volume\\Client", "fromLink": "Docker/Volume/Client.html", "link": "Docker/Volume/Client.html#method_prune", "name": "Docker\\Volume\\Client::prune", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Docker\\Volume", "fromLink": "Docker/Volume.html", "link": "Docker/Volume/ServiceProvider.html", "name": "Docker\\Volume\\ServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Docker\\Volume\\ServiceProvider", "fromLink": "Docker/Volume/ServiceProvider.html", "link": "Docker/Volume/ServiceProvider.html#method_register", "name": "Docker\\Volume\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


