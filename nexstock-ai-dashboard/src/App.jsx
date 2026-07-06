import { useState } from 'react';
import Sidebar from './components/Sidebar';
import DashboardLayout from './components/DashboardLayout';
import MasterInventory from './components/MasterInventory';
import ActionModal from './components/ActionModal';
import DemandForecasting from './components/DemandForecasting';
import PurchaseOrders from './components/PurchaseOrders';

function App() {
  const [activeTab, setActiveTab] = useState('dashboard');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);

  const handleOpenModal = () => setIsModalOpen(true);
  const handleCloseModal = () => setIsModalOpen(false);
  const toggleSidebar = () => setIsSidebarOpen(!isSidebarOpen);

  return (
    <div className="flex min-h-screen bg-[var(--background)] overflow-hidden">
      <Sidebar 
        activeTab={activeTab} 
        setActiveTab={setActiveTab} 
        isSidebarOpen={isSidebarOpen}
        toggleSidebar={toggleSidebar}
      />
      
      <main className="flex-1 flex flex-col h-screen overflow-y-auto w-full relative">
        {activeTab === 'dashboard' && <DashboardLayout onOpenModal={handleOpenModal} />}
        {activeTab === 'inventory' && <MasterInventory />}
        {activeTab === 'forecasting' && <DemandForecasting />}
        {activeTab === 'purchase_orders' && <PurchaseOrders />}
        
        {/* Placeholder for settings */}
        {activeTab === 'settings' && (
          <div className="flex-1 flex items-center justify-center p-8 text-gray-500">
            <p>Settings section is under construction for the hackathon demo.</p>
          </div>
        )}
      </main>

      <ActionModal isOpen={isModalOpen} onClose={handleCloseModal} />
    </div>
  );
}

export default App;
